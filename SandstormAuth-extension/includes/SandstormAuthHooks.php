<?php


class SandstormAuthHooks {
	public static function onLoadExtensionShemaUpdates(DatabaseUpdater $updater) {
		$updater->getDB()->query(
			"CREATE TABLE IF NOT EXISTS sandsorm_users " .
			"    ( user_id VARCHAR PRIMARY KEY" .
			"    , username VARCHAR UNIQUE NOT NULL" .
			"    , permissions VARCHAR NOT NULL" .
			"    )"
		)
	}
}
