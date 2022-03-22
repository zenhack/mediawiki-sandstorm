<?php

use MediaWiki\Session\SessionBackend;
use MediaWiki\Session\SessionInfo;
use MediaWiki\Session\SessionProvider;
use MediaWiki\Session\UserInfo;

class SandstormSessionProvider extends SessionProvider {
	public function provideSessionInfo( WebRequest $request ) {
		$h = $request->getAllHeaders();
		$username = urldecode($h['X-SANDSTORM-USERNAME']);
		$user_id = array_key_exists('X-SANDSTORM-USER-ID', $h)
			? $h['X-SANDSTORM-USER-ID']
			: "";
		$permissions = $h['X-SANDSTORM-PERMISSIONS'];
		$tabId = $h['X-SANDSTORM-TAB-ID'];

		if($user_id === "") {
			$username .= ' ' . substr($tabId, 0, 8);
		}

		// TODO: deduplicate usernames.
		// TODO: do something with permissions.

		return new SessionInfo(SessionInfo::MAX_PRIORITY, [
			"provider" => $this,
			"id" => $tabId,
			"userInfo" => UserInfo::newFromName($username, true),
		]);
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
