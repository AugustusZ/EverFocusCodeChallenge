# EverFocus Code Challenge

Please click [here](http://everfocuscodechallenge.appspot.com/) to see this project. 

## Developed with
- [Brackets](https://github.com/adobe/brackets/) (version: 1.6.0)
- [Google App Engine Launcher](https://cloud.google.com/appengine/downloads#Google_App_Engine_SDK_for_PHP) (Google App Engine SDK for PHP, version: 1.9.35)


## Server
- Google Application Engine
- PHP version: 5.5

## Assumptions
- A valid value for `name` is a single **capitalized** word, 1 <= #characters <= 45
- A valid value for `employeeno` only consists of digits, 1 <= #digits <= 20
- A valid value for `gender` is either `Male` or `Female`
- A valid value for `department` is a word or words, 1 <= #characters <= 45
- The client has the access to modify database, i.e., the database file `employee.csv` will be updated with the data client side send. To achieve this, configure `php.ini` as

		google_app_engine.disable_readonly_filesystem = 1 
		
	This is, of course, dangerous when there is no access restriction. 

## Issues fixing
### Adding new item works on localhost but not on remote server

After hours of search and a good sleep, I found the explanation from [Google official documentations](https://cloud.google.com/appengine/docs/php/googlestorage/):
>One major difference between writing to a local disk and writing to Google Cloud Storage is that Google Cloud Storage doesn’t support modifying or appending to a file after you close it.

Therefore, when trying to add new record data `$new_record`, `file_put_contents($filename, $new_record, FILE_APPEND | LOCK_EX);` works on localhost but **NOT** on Google Cloud Storage. So,

>... you must create a new file with the same name, which overwrites the original.

#### Solution:
1. Overwriting file instead of appending: 

		file_put_contents($filename, file_get_contents($filename) . $new_record);

2. Meanwhile, use Google Cloud Storage bucket to store the `.csv` file (with `777` access) and the bucket for this project is `everfocus`: 

		$filename = 'gs://everfocus/'.$filename;

## DLL (for Part 2)
Windows and Linux (which Google Cloud Storage uses) use completely different executable formats (PE vs. ELF), so a DLL on Linux is definitely **NOT** a COM one. Two approaches:

1. Write a Linux `.so` and run it on Google Cloud Storage server where part 1 PHP code runs.
2. Write a Windows `.dll` (non-COM) and run it on some Windows server.

### Linux DLL

Please refer to repository [Call DLL on Linux](https://github.com/AugustusZ/CallDllOnLinux) which shows that PHP can work with non-COM DLL file.

However, when embedded in HTML on server (Google Cloud), the code of PHP:

	<h1>
		<?php echo shell_exec('./printHelloworld');?>
	</h1>

will **NOT** work, as the log reads:

> PHP Warning:  shell_exec() has been disabled for security reasons in ...

because, for the sake of security, as [Google official documentations](https://cloud.google.com/appengine/docs/php/runtime#PHP_Disabled_functions) said:

> ... **`shell_exec`**, `passthru`, `system`, `exec` ... have been permanently disabled in Google App Engine

In conclusion, with the working [repository](https://github.com/AugustusZ/CallDllOnLinux) given above, it is safe to say that calling-DLL will work fine on the servers with proper security settings, such as:

- `safe-mode = Off`
- `enable_functions = "shell_exec"`
- etc.

### Windows DLL
- [DLL Tutorial For Beginners (Win)](http://www.codeguru.com/cpp/cpp/cpp_mfc/tutorials/article.php/c9855/DLL-Tutorial-For-Beginners.htm)

Please refer to repository ...[]()



## Reference 
- http://www.ibm.com/developerworks/library/l-dll/
- http://www.ibm.com/developerworks/library/l-dynamic-libraries/
- [C++ Dynamic Linking vs Static Linking](https://youtu.be/Jzh4ZULXsvo)
- [What is a DLL file?](https://youtu.be/Mam2YMosk6A)
- [DLL](http://www.webopedia.com/TERM/D/DLL.html)
- [What is a dll?](http://stackoverflow.com/questions/484452/what-is-a-dll)
