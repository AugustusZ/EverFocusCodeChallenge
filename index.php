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
    <script type="text/javascript">
        function clearAll() {
            $(":text").val("");
            $("select").val("Male");
        }

    </script>

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

        <form name="form" method="GET" action="">
            <div id='fields'>
                <label>Name</label>
                <input type="text" name="name" value="Steward" required pattern="^[A-Z][a-z]{1,44}$">

                <br>

                <label>Employee Number</label>
                <input type="text" name="employeeno" value="0000000001" required pattern="^\d{1,20}$">

                <br>

                <label>Gender</label>
                <select name="gender" required>
                    <option value="male" selected>Male</option>
                    <option value="female">Female</option>
                </select>

                <br>

                <label>Department</label>
                <input type="text" name="department" value="Engineer" required pattern="^[a-zA-Z]{1,45}$">
            </div>
            <div id="buttons">
                <input id="submit" type="submit" name="insert" value="Insert" autofocus>
                <input type="button" value="Clear" onclick="clearAll()">
            </div>
        </form>


        <?php
    
    if (isset($_GET["insert"])) { 
        echo "<pre>";
        print_r($_GET);
        echo "</pre>";
        insert(); 
    }
    
    function insert() {
        insert_to_html();
        insert_to_database();
    }
    
    function insert_to_html() {
        
    }
    
    function insert_to_database() {
        
    }
    ?>
</body>

</html>
