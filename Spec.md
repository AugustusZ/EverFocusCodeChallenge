# EverFocus Code Challenge

## Part 1### DescriptionDesign and implement a client-server architecture that would display employees' information in a web page. ### Main Features
1.	By default, the web page should display all the employee's information (i.e. Name, EmployeeNo, Gender, Department) that is already stored in the database (Please refer to `"employee.csv"` file in the attachment).
	
	**Notes:**
	
	The data type of each column in database:
		- `idemployee`: Primary Key, not Null, auto-increment	- `name`: VARCHAR(45)	- `employees`: VARCHAR(20)	- `gender`: VARCHAR(10)	- `department`: VARCHAR(45) 	
2.	Provide input fields to allow user to add new employee item:

	- Name: `Steward`	- EmployeeNo: `0000000001`	- Gender: `Male`	- Department: `Engineer`3.	Display all the employee's information after insertion.
4.	Bonus: It will be desirable if you can make your web page responsive to different screen sizes.### Requirements1.	Server side scripts are expected to implement in PHP language.## Part 2 (This is a bonus question)### DescriptionDLL is good to use because we can encapsulate functions in it and is ready to use.
This question requires you to build a `.dll` file and use PHP code to call the dll functions. You may know that there are traditional dll and COM dll. In this question, you are required to call traditional dll using PHP.### Requirements1.	Build a dll (Not COM DLL). There is only one function Helloworld in dll. which can return `"Hello world"` as a string.2.	Write codes in PHP to call the Helloworld function and show the "Hello world" on the web page above your employee information table.### Hints1.	One possible solution to this problem is that you could write a small C++ application to call your DLL functions, and use PHP's many shell functions (linked below) to retrieve the data/return values from your functions.
	Shell execution functions:
		- http://www.php.net/passthru	- http://www.php.net/shell_exec	- http://www.php.net/system	- http://www.php.net/exec2.	For traditional and COM DLL. 
	There is a link that maybe helpful: http://stackoverflow.com/questions/3016683/the-difference-between-traditional-dll-and-com-dll3.	You're welcome to use any idea you have to do this, as long as you can call TRADITIONAL DLL function in PHP file.## Submission:1.	Candidate is expected to add comments in the code where applicable.2.	Submission should include complete code as well as `.csv` file.