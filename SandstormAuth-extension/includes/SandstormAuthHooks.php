<?php


class SandstormAuthHooks {
	public static function onLoadExtensionSchemaUpdates(DatabaseUpdater $updater) {
		$updater->getDB()->query(
			"CREATE TABLE IF NOT EXISTS sandsorm_user " .
			"    ( user_id VARCHAR PRIMARY KEY" .
			"    , username VARCHAR UNIQUE NOT NULL" .
			"    , permissions VARCHAR NOT NULL" .
			"    )"
		)
	}
}
