<?php

Autoloader::map(array(	
	'Dbdbbackup'       => path('bundle').'dbdbbackup/dbdbbackup.php',
	'DbBackup\\Backup' => __DIR__.'/libraries/backup.php',
));

// Get tokens then store them

$dropbox_session = IoC::resolve('dropbox::session');
$access_token = $dropbox_session->get('access_token');
$dropbox_session->set($access_token, 'access_token');

Config::set('dropbox::config.access_token', array(
	'oauth_token_secret' => $access_token->oauth_token_secret,
	'oauth_token'        => $access_token->oauth_token,
	'uid'                => $access_token->uid
));