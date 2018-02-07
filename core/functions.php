<?php

/**
 *
 * @package phpBB Extension - mChat
 * @copyright (c) 2016 dmzx - http://www.dmzx-web.net
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\mchat\core;

use phpbb\auth\auth;
use phpbb\cache\driver\driver_interface as cache_interface;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\dispatcher_interface;
use phpbb\group\helper;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\user;

class functions
{
	/** @var settings */
	protected $settings;

	/** @var notifications */
	protected $notifications;

	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var auth */
	protected $auth;

	/** @var log_interface */
	protected $log;

	/** @var db_interface */
	protected $db;

	/** @var cache_interface */
	protected $cache;

	/** @var dispatcher_interface */
	protected $dispatcher;

	/** @var helper */
	protected $group_helper;

	/** @var array */
	protected $active_users;

	/** @var array */
	public $log_types = [
		1 => 'edit',
		2 => 'del',
	];

	/**
	 * Constructor
	 *
	 * @param settings				$settings
	 * @param notifications			$notifications
	 * @param user					$user
	 * @param language				$lang
	 * @param auth					$auth
	 * @param log_interface			$log
	 * @param db_interface			$db
	 * @param cache_interface		$cache
	 * @param dispatcher_interface	$dispatcher
	 * @param helper				$group_helper

	 */
	function __construct(
		settings $settings,
		notifications $notifications,
		user $user,
		language $lang,
		auth $auth,
		log_interface $log,
		db_interface $db,
		cache_interface $cache,
		dispatcher_interface $dispatcher,
		helper $group_helper
	)
	{
		$this->settings			= $settings;
		$this->notifications	= $notifications;
		$this->user				= $user;
		$this->lang				= $lang;
		$this->auth				= $auth;
		$this->log				= $log;
		$this->db				= $db;
		$this->cache			= $cache;
		$this->dispatcher		= $dispatcher;
		$this->group_helper		= $group_helper;
	}

	/**
	 * Converts a number of seconds to a string in the format 'x hours y minutes z seconds'
	 *
	 * @param int $time
	 * @return string
	 */
	protected function mchat_format_seconds($time)
	{
		$times = [];

		$hours = floor($time / 3600);
		if ($hours)
		{
			$time -= $hours * 3600;
			$times[] = $this->lang->lang('MCHAT_HOURS', $hours);
		}

		$minutes = floor($time / 60);
		if ($minutes)
		{
			$time -= $minutes * 60;
			$times[] = $this->lang->lang('MCHAT_MINUTES', $minutes);
		}

		$seconds = ceil($time);
		if ($seconds)
		{
			$times[] = $this->lang->lang('MCHAT_SECONDS', $seconds);
		}

		return $this->lang->lang('MCHAT_ONLINE_EXPLAIN', implode('&nbsp;', $times));
	}

	/**
	 * Returns the total session time in seconds
	 *
	 * @return int
	 */
	protected function mchat_session_time()
	{
		$mchat_timeout = $this->settings->cfg('mchat_timeout');
		if ($mchat_timeout)
		{
			return $mchat_timeout;
		}

		$load_online_time = $this->settings->cfg('load_online_time');
		if ($load_online_time)
		{
			return $load_online_time * 60;
		}

		return $this->settings->cfg('session_length');
	}

	/**
	 * Returns data about users who are currently chatting
	 *
	 * @param bool $cached Whether to return possibly cached data
	 * @return array
	 */
	public function mchat_active_users($cached = true)
	{
		if ($cached && $this->active_users)
		{
			return $this->active_users;
		}

		$check_time = time() - $this->mchat_session_time();

		$sql_array = [
			'SELECT'	=> 'u.user_id, u.username, u.user_colour, s.session_viewonline',
			'FROM'		=> [
				$this->settings->get_table_mchat_sessions() => 'ms'
			],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [SESSIONS_TABLE => 's'],
					'ON'	=> 'ms.user_id = s.session_user_id',
				],
				[
					'FROM'	=> [USERS_TABLE => 'u'],
					'ON'	=> 'ms.user_id = u.user_id',
				],
			],
			'WHERE'		=> 'u.user_id <> ' . ANONYMOUS . ' AND s.session_viewonline IS NOT NULL AND ms.user_lastupdate > ' . (int) $check_time,
			'ORDER_BY'	=> 'u.username ASC',
		];

		/**
		 * Event to modify the SQL query that fetches active mChat users
		 *
		 * @event dmzx.mchat.active_users_sql_before
		 * @var array	sql_array	Array with SQL query data to fetch the current active sessions
		 * @since 2.0.0-RC6
		 */
		$vars = [
			'sql_array',
		];
		extract($this->dispatcher->trigger_event('dmzx.mchat.active_users_sql_before', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$mchat_users = [];
		$can_view_hidden = $this->auth->acl_get('u_viewonline');

		foreach ($rows as $row)
		{
			if (!$row['session_viewonline'])
			{
				if (!$can_view_hidden && $row['user_id'] !== $this->user->data['user_id'])
				{
					continue;
				}

				$row['username'] = '<em>' . $row['username'] . '</em>';
			}

			$mchat_users[$row['user_id']] = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'], $this->lang->lang('GUEST'));
		}

		$active_users = [
			'online_userlist'	=> implode($this->lang->lang('COMMA_SEPARATOR'), $mchat_users),
			'users_count_title'	=> $this->lang->lang('MCHAT_TITLE_COUNT', count($mchat_users)),
			'users_total'		=> $this->lang->lang('MCHAT_ONLINE_USERS_TOTAL', count($mchat_users)),
			'refresh_message'	=> $this->mchat_format_seconds($this->mchat_session_time()),
		];

		/**
		 * Event to modify collected data about active mChat users
		 *
		 * @event dmzx.mchat.active_users_after
		 * @var array	mchat_users		Array containing all currently active mChat sessions, mapping from user ID to full username
		 * @var array	active_users	Array containing info about currently active mChat users
		 * @since 2.0.0-RC6
		 */
		$vars = [
			'mchat_users',
			'active_users',
		];
		extract($this->dispatcher->trigger_event('dmzx.mchat.active_users_after', compact($vars)));

		$this->active_users = $active_users;

		return $active_users;
	}

	/**
	 * Inserts the current user into the mchat_sessions table
	 *
	 * @return bool Returns true if a new session was created, otherwise false
	 */
	public function mchat_add_user_session()
	{
		if (!$this->user->data['is_registered'] || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
		{
			return false;
		}

		$sql = 'UPDATE ' . $this->settings->get_table_mchat_sessions() . '
			SET user_lastupdate = ' . time() . '
			WHERE user_id = ' . (int) $this->user->data['user_id'];
		$this->db->sql_query($sql);

		$is_new_session = $this->db->sql_affectedrows() < 1;

		if ($is_new_session)
		{
			$sql = 'INSERT INTO ' . $this->settings->get_table_mchat_sessions() . ' ' . $this->db->sql_build_array('INSERT', [
				'user_id'			=> (int) $this->user->data['user_id'],
				'user_ip'			=> $this->user->ip,
				'user_lastupdate'	=> time(),
			]);
			$this->db->sql_query($sql);
		}

		return $is_new_session;
	}

	/**
	 * Remove expired sessions from the database
	 */
	public function mchat_session_gc()
	{
		$check_time = time() - $this->mchat_session_time();

		$sql = 'DELETE FROM ' . $this->settings->get_table_mchat_sessions() . '
			WHERE user_lastupdate <= ' . (int) $check_time;
		$this->db->sql_query($sql);
	}

	/**
	 * Prune messages
	 *
	 * @param int|array $user_ids
	 * @return array
	 */
	public function mchat_prune($user_ids = [])
	{
		$prune_num = (int) $this->settings->cfg('mchat_prune_num');
		$prune_mode = (int) $this->settings->cfg('mchat_prune_mode');

		if (empty($this->settings->prune_modes[$prune_mode]))
		{
			return [];
		}

		$sql_array = [
			'SELECT'	=> 'message_id',
			'FROM'		=> [$this->settings->get_table_mchat() => 'm'],
		];

		if ($user_ids)
		{
			if (!is_array($user_ids))
			{
				$user_ids = [$user_ids];
			}

			$sql_array['WHERE'] = $this->db->sql_in_set('m.user_id', $user_ids);
			$offset = 0;
		}
		else if ($this->settings->prune_modes[$prune_mode] === 'messages')
		{
			// Skip fixed number of messages, delete all others
			$sql_array['ORDER_BY'] = 'm.message_id DESC';
			$offset = $prune_num;
		}
		else
		{
			// Delete messages older than time period
			$sql_array['WHERE'] = 'm.message_time < ' . (int) strtotime($prune_num * $prune_mode . ' hours ago');
			$offset = 0;
		}

		/**
		 * Allow modifying SQL query before message ids to be pruned are retrieved.
		 *
		 * @event dmzx.mchat.prune_sql_before
		 * @var array	user_ids	Array of user IDs that are being pruned, empty when pruning via cron
		 * @var array	sql_array	SQL query data
		 * @since 2.0.2
		 */
		$vars = [
			'user_ids',
			'sql_array',
		];
		extract($this->dispatcher->trigger_event('dmzx.mchat.prune_sql_before', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, 0, $offset);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$prune_ids = [];

		foreach ($rows as $row)
		{
			$prune_ids[] = (int) $row['message_id'];
		}

		/**
		 * Event to modify messages that are about to be pruned
		 *
		 * @event dmzx.mchat.prune_before
		 * @var array	prune_ids	Array of message IDs that are about to be pruned
		 * @var array	user_ids	Array of user IDs that are being pruned, empty when pruning via cron
		 * @since 2.0.0-RC6
		 * @changed 2.0.1 Added user_ids
		 */
		$vars = [
			'prune_ids',
			'user_ids',
		];
		extract($this->dispatcher->trigger_event('dmzx.mchat.prune_before', compact($vars)));

		if ($prune_ids)
		{
			$this->db->sql_query('DELETE FROM ' . $this->settings->get_table_mchat() . ' WHERE ' . $this->db->sql_in_set('message_id', $prune_ids));
			$this->db->sql_query('DELETE FROM ' . $this->settings->get_table_mchat_log() . ' WHERE ' . $this->db->sql_in_set('message_id', $prune_ids));
			$this->cache->destroy('sql', $this->settings->get_table_mchat_log());

			// Only add a log entry if message pruning was not triggered by user pruning
			if (!$user_ids)
			{
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_MCHAT_TABLE_PRUNED', false, [$this->user->data['username'], count($prune_ids)]);
			}
		}

		return $prune_ids;
	}

	/**
	 * Returns the total number of messages
	 *
	 * @return int
	 */
	public function mchat_total_message_count()
	{
		$sql_array = [
			'SELECT'	=> 'COUNT(*) AS rows_total',
			'FROM'		=> [$this->settings->get_table_mchat() => 'm'],
			'WHERE'		=> $this->notifications->get_sql_where(),
		];

		/**
		 * Event to modifying the SQL query that fetches the total number of mChat messages
		 *
		 * @event dmzx.mchat.total_message_count_modify_sql
		 * @var array	sql_array	Array with SQL query data to fetch the total message count
		 * @since 2.0.0-RC6
		 */
		$vars = [
			'sql_array',
		];
		extract($this->dispatcher->trigger_event('dmzx.mchat.total_message_count_modify_sql', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$rows_total = $this->db->sql_fetchfield('rows_total');
		$this->db->sql_freeresult($result);

		return (int) $rows_total;
	}

	/**
	 * Fetch messages from the database
	 *
	 * @param int|array $message_ids IDs of specific messages to fetch, e.g. for fetching edited messages
	 * @param int $last_id The ID of the latest message that the user has, for fetching new messages
	 * @param int $total
	 * @param int $offset
	 * @return array
	 */
	public function mchat_get_messages($message_ids, $last_id = 0, $total = 0, $offset = 0)
	{
		$sql_where_message_id = [];

		// Fetch new messages
		if ($last_id)
		{
			$sql_where_message_id[] = 'm.message_id > ' . (int) $last_id;
		}

		// Fetch edited messages
		if ($message_ids)
		{
			if (!is_array($message_ids))
			{
				$message_ids = [$message_ids];
			}

			$sql_where_message_id[] = $this->db->sql_in_set('m.message_id', array_map('intval', $message_ids));
		}

		$sql_where_ary = array_filter([
			implode(' OR ', $sql_where_message_id),
			$this->notifications->get_sql_where(),
		]);

		$sql_array = [
			'SELECT'	=> 'm.*, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, u.user_allow_pm, p.post_visibility',
			'FROM'		=> [$this->settings->get_table_mchat() => 'm'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [USERS_TABLE => 'u'],
					'ON'	=> 'm.user_id = u.user_id',
				],
				[
					'FROM'	=> [POSTS_TABLE => 'p'],
					'ON'	=> 'm.post_id = p.post_id AND m.forum_id <> 0',
				],
			],
			'WHERE'		=> $sql_where_ary ? $this->db->sql_escape('(' . implode(') AND (', $sql_where_ary) . ')') : '',
			'ORDER_BY'	=> 'm.message_id DESC',
		];

		/**
		 * Event to modify the SQL query that fetches mChat messages
		 *
		 * @event dmzx.mchat.get_messages_modify_sql
		 * @var array	message_ids	IDs of specific messages to fetch, e.g. for fetching edited messages
		 * @var int		last_id		The ID of the latest message that the user has, for fetching new messages
		 * @var int		total		SQL limit
		 * @var int		offset		SQL offset
		 * @var	array	sql_array	Array containing the SQL query data
		 * @since 2.0.0-RC6
		 */
		$vars = [
			'message_ids',
			'last_id',
			'total',
			'offset',
			'sql_array',
		];
		extract($this->dispatcher->trigger_event('dmzx.mchat.get_messages_modify_sql', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, $total, $offset);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		// Set deleted users to ANONYMOUS
		foreach ($rows as $i => $row)
		{
			if (!isset($row['username']))
			{
				$rows[$i]['user_id'] = ANONYMOUS;
			}
		}

		return $rows;
	}

	/**
	 * Fetches log entries from the database and sorts them
	 *
	 * @param int $log_id The ID of the latest log entry that the user has
	 * @return array
	 */
	public function mchat_get_logs($log_id)
	{
		$sql_array = [
			'SELECT'	=> 'ml.*',
			'FROM'		=> [$this->settings->get_table_mchat_log() => 'ml'],
			'WHERE'		=> 'ml.log_id > ' . (int) $log_id,
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql, 3600);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$logs = [
			'id' => $log_id,
		];

		foreach ($rows as $row)
		{
			$logs['id'] = max((int) $logs['id'], (int) $row['log_id']);
			$logs[] = $row;
		}

		return $logs;
	}

	/**
	 * Fetches the highest log ID
	 *
	 * @return int
	 */
	public function get_latest_log_id()
	{
		$sql_array = [
			'SELECT'	=> 'ml.log_id',
			'FROM'		=> [$this->settings->get_table_mchat_log() => 'ml'],
			'ORDER_BY'	=> 'log_id DESC',
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query_limit($sql, 1);
		$max_log_id = (int) $this->db->sql_fetchfield('log_id');
		$this->db->sql_freeresult($result);

		return $max_log_id;
	}

	/**
	 * Generates the user legend markup
	 *
	 * @return array Array of HTML markup for each group
	 */
	public function mchat_legend()
	{
		// Grab group details for legend display for who is online on the custom page
		$order_legend = $this->settings->cfg('legend_sort_groupname') ? 'group_name' : 'group_legend';

		$sql_array = [
			'SELECT'	=> 'g.group_id, g.group_name, g.group_colour',
			'FROM'		=> [GROUPS_TABLE => 'g'],
			'WHERE'		=> 'group_legend <> 0',
			'ORDER_BY'	=> 'g.' . $order_legend . ' ASC',
		];

		if ($this->auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel'))
		{
			$sql_array['LEFT_JOIN'] = [
				[
					'FROM'	=> [USER_GROUP_TABLE => 'ug'],
					'ON'	=> 'g.group_id = ug.group_id AND ug.user_id = ' . (int) $this->user->data['user_id'] . ' AND ug.user_pending = 0',
				],
			];

			$sql_array['WHERE'] .= ' AND (g.group_type <> ' . GROUP_HIDDEN . ' OR ug.user_id = ' . (int) $this->user->data['user_id'] . ')';
		}

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$legend = [];
		foreach ($rows as $row)
		{
			$colour_text = $row['group_colour'] ? ' style="color:#' . $row['group_colour'] . '"' : '';
			$group_name = $this->group_helper->get_name($row['group_name']);
			if ($row['group_name'] == 'BOTS' || $this->user->data['user_id'] != ANONYMOUS && !$this->auth->acl_get('u_viewprofile'))
			{
				$legend[] = '<span' . $colour_text . '>' . $group_name . '</span>';
			}
			else
			{
				$legend[] = '<a' . $colour_text . ' href="' . append_sid($this->settings->url('memberlist'), ['mode' => 'group', 'g' => $row['group_id']]) . '">' . $group_name . '</a>';
			}
		}

		return $legend;
	}

	/**
	 * Returns a list of all foes of the current user
	 *
	 * @return array Array of user IDs
	 */
	public function mchat_foes()
	{
		$sql = 'SELECT zebra_id
			FROM ' . ZEBRA_TABLE . '
			WHERE foe = 1
				AND user_id = ' . (int) $this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$foes = [];

		foreach ($rows as $row)
		{
			$foes[] = $row['zebra_id'];
		}

		return $foes;
	}

	/**
	 * Adds forbidden BBCodes to the passed SQL where statement
	 *
	 * @param string $sql_where
	 * @return string
	 */
	public function mchat_sql_append_forbidden_bbcodes($sql_where)
	{
		$disallowed_bbcodes = explode('|', $this->settings->cfg('mchat_bbcode_disallowed'));

		if (!empty($disallowed_bbcodes))
		{
			$sql_where .= ' AND ' . $this->db->sql_in_set('b.bbcode_tag', $disallowed_bbcodes, true);
		}

		return $sql_where;
	}

	/**
	 * Checks if the current user is flooding the chat
	 *
	 * @return bool
	 */
	public function mchat_is_user_flooding()
	{
		if (!$this->settings->cfg('mchat_flood_time') || $this->auth->acl_get('u_mchat_flood_ignore'))
		{
			return false;
		}

		$sql = 'SELECT message_time
			FROM ' . $this->settings->get_table_mchat() . '
			WHERE user_id = ' . (int) $this->user->data['user_id'] . '
			ORDER BY message_time DESC';
		$result = $this->db->sql_query_limit($sql, 1);
		$message_time = (int) $this->db->sql_fetchfield('message_time');
		$this->db->sql_freeresult($result);

		return $message_time && time() - $message_time < $this->settings->cfg('mchat_flood_time');
	}

	/**
	 * Returns user ID & name of the specified message
	 *
	 * @param int $message_id
	 * @return array
	 */
	public function mchat_author_for_message($message_id)
	{
		$sql = 'SELECT m.user_id, m.message_time, m.post_id
			FROM ' . $this->settings->get_table_mchat() . ' m
			WHERE m.message_id = ' . (int) $message_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row;
	}

	/**
	 * Performs AJAX actions
	 *
	 * @param string $action One of add|edit|del
	 * @param array $sql_ary
	 * @param int $message_id
	 * @return bool
	 */
	public function mchat_action($action, $sql_ary = null, $message_id = 0)
	{
		$update_session_infos = true;

		/**
		 * Event to modify the SQL query that adds, edits or deletes an mChat message
		 *
		 * @event dmzx.mchat.action_before
		 * @var	string	action					The action that is being performed, one of add|edit|del
		 * @var bool	sql_ary					Array containing SQL data, or null if a message is deleted
		 * @var int		message_id				The ID of the message that is being edited or deleted, or 0 if a message is added
		 * @var bool	update_session_infos	Whether or not to update the user session
		 * @since 2.0.0-RC6
		 */
		$vars = [
			'action',
			'sql_ary',
			'message_id',
			'update_session_infos',
		];
		extract($this->dispatcher->trigger_event('dmzx.mchat.action_before', compact($vars)));

		$is_new_session = false;

		switch ($action)
		{
			// User adds a message
			case 'add':
				if ($update_session_infos)
				{
					$this->user->update_session_infos();
				}
				$is_new_session = $this->mchat_add_user_session();
				$this->db->sql_query('INSERT INTO ' . $this->settings->get_table_mchat() . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));
				break;

			// User edits a message
			case 'edit':
				if ($update_session_infos)
				{
					$this->user->update_session_infos();
				}
				$is_new_session = $this->mchat_add_user_session();
				$this->db->sql_query('UPDATE ' . $this->settings->get_table_mchat() . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . ' WHERE message_id = ' . (int) $message_id);
				$this->mchat_insert_log('edit', $message_id);
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_EDITED_MCHAT', false, [$this->user->data['username']]);
				break;

			// User deletes a message
			case 'del':
				if ($update_session_infos)
				{
					$this->user->update_session_infos();
				}
				$is_new_session = $this->mchat_add_user_session();
				$this->db->sql_query('DELETE FROM ' . $this->settings->get_table_mchat() . ' WHERE message_id = ' . (int) $message_id);
				$this->mchat_insert_log('del', $message_id);
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DELETED_MCHAT', false, [$this->user->data['username']]);
				break;
		}

		return $is_new_session;
	}

	/**
	 * @param string $log_type The log type, one of edit|del
	 * @param int $message_id The ID of the message to which this log entry belongs
	 * @return int The ID of the newly added log row
	 */
	public function mchat_insert_log($log_type, $message_id)
	{
		$this->db->sql_query('INSERT INTO ' . $this->settings->get_table_mchat_log() . ' ' . $this->db->sql_build_array('INSERT', [
			'log_type'		=> array_search($log_type, $this->log_types),
			'user_id'		=> (int) $this->user->data['user_id'],
			'message_id'	=> (int) $message_id,
			'log_ip'		=> $this->user->ip,
			'log_time'		=> time(),
			]));

		$log_id = (int) $this->db->sql_nextid();

		$this->cache->destroy('sql', $this->settings->get_table_mchat_log());

		return $log_id;
	}
}
