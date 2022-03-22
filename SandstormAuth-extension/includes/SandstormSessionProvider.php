<?php

use MediaWiki\Session\SessionBackend;
use MediaWiki\Session\SessionInfo;
use MediaWiki\Session\SessionProvider;
use MediaWiki\Session\UserInfo;

class SandstormSessionProvider extends SessionProvider {
	private $sandstormDB;

	protected function postInitSetup() {
		$this->sandstormDB = DatabaseSqlite::newStandaloneInstance("/var/sandstorm-extension.sqlite");
		$this->sandstormDB->query(
			"CREATE TABLE IF NOT EXISTS sandstorm_user " .
			"    ( user_id VARCHAR PRIMARY KEY" .
			"    , username VARCHAR UNIQUE NOT NULL" .
			"    , permissions VARCHAR NOT NULL" .
			"    )"
		);
	}

	public function provideSessionInfo( WebRequest $request ) {
		$h = $request->getAllHeaders();
		$user_id = array_key_exists('X-SANDSTORM-USER-ID', $h)
			? $h['X-SANDSTORM-USER-ID']
			: "";
		$username = urldecode($h['X-SANDSTORM-USERNAME']);
		$permissions = $h['X-SANDSTORM-PERMISSIONS'];
		$tabId = $h['X-SANDSTORM-TAB-ID'];

		$username = $this->ensureUser($user_id, $username, $permissions, $tabId);

		// TODO: enforce permissions somehow.

		return new SessionInfo(SessionInfo::MAX_PRIORITY, [
			"provider" => $this,
			"id" => $tabId,
			"userInfo" => UserInfo::newFromName($username, true),
		]);
	}

	private function ensureUser($user_id, $username, $permissions, $tabId) {
		$isAnon = $user_id === "";
		if($isAnon) {
			$anon_id = substr($tabId, 0, 8);
			$user_id = "anonymous-" . $anon_id;
			$username .= ' ' . $anon_id;
		} else {
			$user_id = "logged-in-" . $user_id;
		}

		$db = $this->sandstormDB;
		$res = $db->select(
			'sandstorm_user',
			['username', 'permissions'],
			['user_id' => $user_id],
		);
		if($res->numRows() > 0) {
			$row = $res->fetchRow();
			$username = $row['username'];
			$old_permissions = $row['permissions'];
			$res->free();
			if($permissions !== $old_permissions) {
				$db->update(
					'sandstorm_user',
					['permissions' => $permissions],
					['user_id' => $user_id],
				);
			}
		} else {
			$res->free();
			while(true) {
				$db->insert(
					'sandstorm_user',
					[
						'user_id' => $user_id,
						'username' => $username,
						'permissions' => $permissions,
					],
					__METHOD__,
					['IGNORE'],
				);
				if($db->affectedRows() > 0) {
					break;
				}
				// Keep appending " 2" until we get a unique username.
				$username .= ' 2';
			}
		}


		return $username;
	}

	public function getVaryHeaders() {
		return [
			'X-SANDSTORM-USERNAME',
			'X-SANDSTORM-USER-ID',
			'X-SANDSTORM-PERMISSIONS',
			'X-SANDSTORM-TAB-ID',
		];
	}

	public function persistsSessionId() { return false; }
	public function canChangeUser() { return false; }
	public function persistSession( SessionBackend $session, WebRequest $request ) {}
	public function unpersistSession( WebRequest $request ) {}
}
