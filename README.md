# EverFocus Code Challenge

Please click [here](http://everfocuscodechallenge.appspot.com/) to see this project. 

## Developed with
- [Brackets](https://github.com/adobe/brackets/) (version: 1.6.0)
- [Google App Engine Launcher](https://cloud.google.com/appengine/downloads#Google_App_Engine_SDK_for_PHP) (Google App Engine SDK for PHP, version: 1.9.35)


## Server
The project is deployed on Google Application Engine.

## PHP Version
- `str_getcsv()`: PHP 5 >= 5.3.0, PHP 7

## Assumptions
- A valid value for `name` is a single **capitalized** word, 1 <= #characters <= 45
- A valid value for `employeeno` only consists of digits, 1 <= #digits <= 20
- A valid value for `gender` is either `Male` or `Female`
- A valid value for `department` is a single word, 1 <= #characters <= 45
- The client has the access to modify database, i.e., the database file `employee.csv` will be updated with the data client side send. To achieve this, configure `php.ini` as

		google_app_engine.disable_readonly_filesystem = 1 
		
	This is, of course, dangerous when there is no access restriction. 
- 	


