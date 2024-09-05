<?php

/**
 * Fired during plugin deactivation
 */


class Index_Watcher_Deactivator
{

	public static function deactivate()

	{

		$timestamp = wp_next_scheduled('my_custom_cronjob');
		wp_unschedule_event($timestamp, 'my_custom_cronjob');
	}
}
