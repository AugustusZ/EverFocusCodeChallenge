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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap.js"></script>
</head>

<body>
    <h1>Hello, world!</h1>

    <?php
    display_csv("employee.csv", "r");
    
    function parse_to_tr($string, $tag_name) {
        $html = "";
        $array = str_getcsv($string, $delimiter = ";", $enclosure = '"');
        foreach ($array as $value) {
            $html .= "<$tag_name>$value</$tag_name>";
        }
        $html = "<tr>$html</tr>";
            
        return $html;
    }
    
    function display_csv($filename) {
        // when reading files either on or created by a Macintosh computer
        ini_set("auto_detect_line_endings", true);
        
        echo "<table>";

        $file = fopen($filename, "r");
        echo parse_to_tr(fgets($file), "th"); 

        // read one line from csv file in each loop
        while(! feof($file)) {
            echo parse_to_tr(fgets($file), "td"); 
        }
        fclose($file);

        echo "</table>";
    }
    ?>

</body>

</html>
