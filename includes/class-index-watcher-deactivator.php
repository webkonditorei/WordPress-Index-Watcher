<?php

/**
 * Fired during plugin deactivation
 */


class Index_Watcher_Deactivator
{

	public static function deactivate()

	{

		$timestamp = wp_next_scheduled('index_watcher_cronjob');
		wp_unschedule_event($timestamp, 'index_watcher_cronjob');
	}
}
