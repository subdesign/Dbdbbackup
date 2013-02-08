<?php 

/**
 * DropBox DataBase backup
 */

class Dbdbbackup
{
	
	public static function backup()
	{
		$filepath = DbBackup\Backup::make(Config::get('Dbdbbackup::config.hostname'), 
										  Config::get('Dbdbbackup::config.username'), 
										  Config::get('Dbdbbackup::config.password'), 
										  Config::get('Dbdbbackup::config.database'), 
										  Config::get('Dbdbbackup::config.tables'), true);

		$dropbox_session = IoC::resolve('dropbox::session');
		$access_token = $dropbox_session->get('access_token');
		$dropbox_session->set($access_token, 'access_token');

		$dropbox = IoC::resolve('dropbox::api');
		
		$put = $dropbox->putFile($filepath);		

		unlink($filepath);

		Log::write('info', 'Backup saved -- '.substr($filepath, 17));

	}

}