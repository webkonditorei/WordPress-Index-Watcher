<?php

/**
 *
 * @link              https://https://webkonditorei.de/
 * @since             1.0.0
 * @package           Index_Watcher
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Index Watcher
 * Plugin URI:        https://https://webkonditorei.de/
 * Description:       This plugin checks once a day whether your WordPress website has been set to No-Index with the WP built-in No-Index function. If so, it will be set to index again.
 * Version:           1.0.0
 * Author:            webkonditorei
 * Author URI:        https://https://webkonditorei.de/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       index-watcher
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

define('INDEX_WATCHER_VERSION', '1.0.0');


function deactivate_index_watcher()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-index-watcher-deactivator.php';
	Index_Watcher_Deactivator::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_index_watcher');


function run_index_watcher()
{


	function custom_cron_schedule($schedules)
	{
		$schedules['every_two_minutes'] = array(
			'interval' => 86400,
			'display'  => __('Once Daily'),
		);
		return $schedules;
	}
	add_filter('cron_schedules', 'custom_cron_schedule');


	function setup_index_watcher_cronjob()
	{
		if (!wp_next_scheduled('index_watcher_cronjob')) {
			wp_schedule_event(time(), 'every_two_minutes', 'index_watcher_cronjob');
		}
	}
	add_action('wp_loaded', 'setup_index_watcher_cronjob');

	function set_site_to_index()
	{
		$indexing_status = get_option('blog_public');

		if ($indexing_status === '0') {
			update_option('blog_public', '1');
		}
	}
	add_action('index_watcher_cronjob', 'set_site_to_index');
}
run_index_watcher();
