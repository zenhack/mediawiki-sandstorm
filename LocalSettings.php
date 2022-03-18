<?php
# This file was automatically generated by the MediaWiki 1.23.0
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "Wiki";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";
$wgScriptExtension = ".php";

## The protocol and server name to use in fully-qualified URLs
$wgServer = '//' . $_SERVER['HTTP_HOST'];

## The relative URL path to the skins directory
$wgStylePath = "$wgScriptPath/skins";

## The relative URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@localhost:10000";
$wgPasswordSender = "apache@localhost:10000";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "sqlite";
$wgDBserver = "";
$wgDBname = "wiki";
$wgDBuser = "";
$wgDBpassword = "";

# SQLite-specific settings
$wgSQLiteDataDir = "/var/wiki";

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgMemCachedServers = array();

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from http://commons.wikimedia.org
$wgUseInstantCommons = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
#$wgHashedUploadDirectory = false;

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/Names.php
$wgLanguageCode = "en";

$wgSecretKey = "ccd66ae0be6d755d059bd990e8fc98c9a8b63b95f055b781f054ad8a47f7677c";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "1e37be2963f3deaa";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'cologneblue', 'monobook', 'vector':
#
#(zenhack): this was in Jason's version, but the file doesn't exist. See if it
#works without it...
#require_once "$IP/skins/Vector/Vector.php";

$wgDefaultSkin = "vector";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";
# End of automatically generated settings.
# Add more configuration options below.

$wgUsePathInfo = true;
$wgBreakFrames = false;
$wgEditPageFrameOptions = false;
$wgEnableUserEmail = false;
$wgGroupPermissions = array();

/** @cond file_level_code */
// Implicit group for all visitors
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['read'] = true;
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['createpage'] = false;
$wgGroupPermissions['*']['createtalk'] = false;
$wgGroupPermissions['*']['writeapi'] = false;
$wgGroupPermissions['*']['editmyusercss'] = true;
$wgGroupPermissions['*']['editmyuserjs'] = true;
$wgGroupPermissions['*']['viewmywatchlist'] = true;
$wgGroupPermissions['*']['editmywatchlist'] = true;
$wgGroupPermissions['*']['viewmyprivateinfo'] = false;
$wgGroupPermissions['*']['editmyprivateinfo'] = true;
$wgGroupPermissions['*']['editmyoptions'] = true;
#$wgGroupPermissions['*']['patrolmarks'] = false; // let anons see what was patrolled

// editor group
$wgGroupPermissions['editor']['move'] = true;
$wgGroupPermissions['editor']['move-subpages'] = true;
$wgGroupPermissions['editor']['move-rootuserpages'] = true; // can move root userpages
$wgGroupPermissions['editor']['movefile'] = true;
$wgGroupPermissions['editor']['read'] = true;
$wgGroupPermissions['editor']['edit'] = true;
$wgGroupPermissions['editor']['createpage'] = true;
$wgGroupPermissions['editor']['createtalk'] = true;
$wgGroupPermissions['editor']['writeapi'] = true;
$wgGroupPermissions['editor']['upload'] = true;
$wgGroupPermissions['editor']['reupload'] = true;
$wgGroupPermissions['editor']['reupload-shared'] = true;
$wgGroupPermissions['editor']['minoredit'] = true;
$wgGroupPermissions['editor']['purge'] = true; // can use ?action=purge without clicking "ok"
$wgGroupPermissions['editor']['sendemail'] = true;

// Implicit group for accounts that pass $wgAutoConfirmAge
$wgGroupPermissions['autoconfirmed']['autoconfirmed'] = true;
$wgGroupPermissions['autoconfirmed']['editsemiprotected'] = true;

// Users with bot privilege can have their edits hidden
// from various log pages by default
$wgGroupPermissions['bot']['bot'] = true;
$wgGroupPermissions['bot']['autoconfirmed'] = true;
$wgGroupPermissions['bot']['editsemiprotected'] = true;
$wgGroupPermissions['bot']['nominornewtalk'] = true;
$wgGroupPermissions['bot']['autopatrol'] = true;
$wgGroupPermissions['bot']['suppressredirect'] = true;
$wgGroupPermissions['bot']['apihighlimits'] = true;
$wgGroupPermissions['bot']['writeapi'] = true;

// Most extra permission abilities go to this group
$wgGroupPermissions['sysop']['block'] = true;
$wgGroupPermissions['sysop']['createaccount'] = true;
$wgGroupPermissions['sysop']['delete'] = true;
// can be separately configured for pages with > $wgDeleteRevisionsLimit revs
$wgGroupPermissions['sysop']['bigdelete'] = true;
// can view deleted history entries, but not see or restore the text
$wgGroupPermissions['sysop']['deletedhistory'] = true;
// can view deleted revision text
$wgGroupPermissions['sysop']['deletedtext'] = true;
$wgGroupPermissions['sysop']['undelete'] = true;
$wgGroupPermissions['sysop']['editinterface'] = true;
$wgGroupPermissions['sysop']['editusercss'] = true;
$wgGroupPermissions['sysop']['edituserjs'] = true;
$wgGroupPermissions['sysop']['import'] = true;
$wgGroupPermissions['sysop']['importupload'] = true;
$wgGroupPermissions['sysop']['move'] = true;
$wgGroupPermissions['sysop']['move-subpages'] = true;
$wgGroupPermissions['sysop']['move-rootuserpages'] = true;
$wgGroupPermissions['sysop']['patrol'] = true;
$wgGroupPermissions['sysop']['autopatrol'] = true;
$wgGroupPermissions['sysop']['protect'] = true;
$wgGroupPermissions['sysop']['editprotected'] = true;
$wgGroupPermissions['sysop']['proxyunbannable'] = true;
$wgGroupPermissions['sysop']['rollback'] = true;
$wgGroupPermissions['sysop']['upload'] = true;
$wgGroupPermissions['sysop']['reupload'] = true;
$wgGroupPermissions['sysop']['reupload-shared'] = true;
$wgGroupPermissions['sysop']['unwatchedpages'] = true;
$wgGroupPermissions['sysop']['autoconfirmed'] = true;
$wgGroupPermissions['sysop']['editsemiprotected'] = true;
$wgGroupPermissions['sysop']['ipblock-exempt'] = true;
$wgGroupPermissions['sysop']['blockemail'] = true;
$wgGroupPermissions['sysop']['markbotedits'] = true;
$wgGroupPermissions['sysop']['apihighlimits'] = true;
$wgGroupPermissions['sysop']['browsearchive'] = true;
$wgGroupPermissions['sysop']['noratelimit'] = true;
$wgGroupPermissions['sysop']['movefile'] = true;
$wgGroupPermissions['sysop']['unblockself'] = true;
$wgGroupPermissions['sysop']['suppressredirect'] = true;
#$wgGroupPermissions['sysop']['upload_by_url'] = true;
#$wgGroupPermissions['sysop']['mergehistory'] = true;

// Permission to change users' group assignments
$wgGroupPermissions['bureaucrat']['userrights'] = true;
$wgGroupPermissions['bureaucrat']['noratelimit'] = true;
$wgScriptPath     = "";
$wgArticlePath      = "/$1";
$wgUsePathInfo      = true;
$wgScriptExtension  = ".php";

/**
 * The filesystem path of the images directory. Defaults to "{$IP}/images".
 */
// $wgUploadDirectory = "/var/mediawiki-images";

/**
 * Directory where the cached page will be saved.
 * Defaults to "{$wgUploadDirectory}/cache".
 */
$wgCacheDirectory = "/var/mediawiki-cache";

$wgMaxUploadSize = 100 * 1024 * 1024;

/**
 * Open external links in new tab *
 */
 $wgExternalLinkTarget = '_blank';

// Load the cite package so the <ref> and <references/> tags work
wfLoadExtension( 'Cite' );

$wgShowExceptionDetails = true;
