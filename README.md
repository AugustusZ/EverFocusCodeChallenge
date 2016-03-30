# EverFocus Code Challenge

Please click [here](http://everfocuscodechallenge.appspot.com/) to see this project. 

## Introduction 
See spec [here](Spec.md).

### Developed with
- [Brackets](https://github.com/adobe/brackets/) (version: 1.6.0)
- [Google App Engine Launcher](https://cloud.google.com/appengine/downloads#Google_App_Engine_SDK_for_PHP) (Google App Engine SDK for PHP, version: 1.9.35)

### Server
- Google Application Engine
- PHP version: 5.5

## Part 1
As there is not explicit specification for the approach to achieve the end goal, the most straightforward one to play with `.csv` would be treating it as a text file lying in the filesystem instead of a source data file to be imported into a database.

### Approach 1: Text file manipulation 
#### Assumptions
- A valid value for `name` is a single **Capitalized** word, 1 <= #characters <= 45
- A valid value for `employeeno` only consists of digits, 1 <= #digits <= 20
- A valid value for `gender` is either `Male` or `Female`
- A valid value for `department` is a word or words, 1 <= #characters <= 45
- The client has the access to modify database, i.e., the database file `employee.csv` will be updated with the data client side send. To achieve this, configure `php.ini` as

		google_app_engine.disable_readonly_filesystem = 1 
		
	Note that this is, of course, dangerous when there is no access restriction.

#### Concerns
As [Google official documentations](https://cloud.google.com/appengine/docs/php/googlestorage/) said:
>One major difference between writing to a local disk and writing to Google Cloud Storage is that Google Cloud Storage doesn’t support modifying or appending to a file after you close it.

Basically it means: when we put the `.csv` file in file system, there are some writability we should take care of; otherwise, you might encounter some funny behaviors, e.g., the operation of adding new item works on localhost but not on Google's remote server. Specifically, when trying to add new record data `$new_record`,

	 file_put_contents($filename, $new_record, FILE_APPEND | LOCK_EX);
	 
works on localhost but **NOT** on Google Cloud Storage. 

The solution for this is, also indicated in [Google official documentations](https://cloud.google.com/appengine/docs/php/googlestorage/):

>... you must create a new file with the same name, which overwrites the original.

And the specific solution is:

1. Overwriting file instead of appending: 

		file_put_contents($filename, file_get_contents($filename) . $new_record);

2. Meanwhile, use Google Cloud Storage bucket to store the `.csv` file (with `777` access) and the bucket for this project is `everfocus`: 

		$filename = 'gs://everfocus/'.$filename;

So the conclusion is, always use overwriting instead of appending and,

- when you on localhost, and put `.csv` file in the same folder with `.php`, use

		$filename = 'everfocus.csv';
	 
- when you on Google server, and put the `.csv` file in the bucket, e.g. `gs://everfocus/`, use 

		$filename = 'gs://everfocus/everfocus.csv';

### Approach 2: Database connection
Use Google Database.


## Part 2
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



### Reference 
- http://www.ibm.com/developerworks/library/l-dll/
- http://www.ibm.com/developerworks/library/l-dynamic-libraries/
- [C++ Dynamic Linking vs Static Linking](https://youtu.be/Jzh4ZULXsvo)
- [What is a DLL file?](https://youtu.be/Mam2YMosk6A)
- [DLL](http://www.webopedia.com/TERM/D/DLL.html)
- [What is a dll?](http://stackoverflow.com/questions/484452/what-is-a-dll)
