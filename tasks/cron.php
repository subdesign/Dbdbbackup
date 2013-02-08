<?php 

class Dbdbbackup_Cron_Task 
{
	
	public function run($arguments)
	{
		Bundle::start('dbdbbackup');
		Dbdbbackup::backup();	
	}

}