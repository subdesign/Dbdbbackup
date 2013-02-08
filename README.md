# Dbdbbackup - DropBox DataBase backup

Backup your database automatically with the help of CRON (or manually) to your Dropbox account.

***

## Dependency

[Dropbox bundle](http://bundles.laravel.com/bundle/dropbox)   

## Installation

Clone the repo, put files into the _bundles/dbdbbackup_ folder.

## Setup

### Dropbox setup

* Autoload Dropbox bundle
* add following code to the _application/start.php_

        Event::listen('laravel.started: dropbox', function()
        {        
  	        $app_key = Config::get('dbdbbackup::config.app_key');
	        $app_secret = Config::get('dbdbbackup::config.app_secret');
	        $encryption_key = Config::get('dbdbbackup::config.encryption_key');
	        $root = Config::get('dbdbbackup::config.root');       
	        
            Config::set('dropbox::config.app_key', $app_key); 
            Config::set('dropbox::config.app_secret', $app_secret);
            Config::set('dropbox::config.encryption_key', $encryption_key);
            Config::set('dropbox::config.root', $root); 
        });
    
### Dbdbbackup setup    
    
* add Dbdbbackup to the bundle configuration (bundles.php)
* fill the bundle config file with appropriate data

        return array(
            'app_key'        => '', // get from dropbox.com
     	    'app_secret'     => '', // get from dropbox.com
     	    'encryption_key' => '',  // generate an encryption key
         	'root'           => 'sandbox', // sandbor or dropbox
	
         	'hostname' => 'localhost',
         	'username' => 'root',
         	'password' => 'password',
         	'database' => '',
         	'tables'   => '*'  // comma separated table names, or use * for all tables
        );
    
## Usage

### Manually run

    Bundle::start('dbdbbackup');
    Dbdbbackup::backup();	

### Run with cron

    ../web/yoursite/artisan dbdbbackup::cron

## License 

[MIT License](http://www.opensource.org/licenses/MIT)

## Author

C. 2013 Barna Szalai <b.sz@devartpro.com>

Feel free to contant me if you have any questions!



