<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Part 1</title>

    <!-- Bootstrap -->
    <link href="bootstrap.css" rel="stylesheet">
</head>

<body>
    <h1>Hello, world!</h1>

    <?php

        $file = fopen("employee.csv","r");

        while(! feof($file)) {
            print_r(fgetcsv($file));
        }

        fclose($file);
    ?>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap.js"></script>
</body>

</html>
