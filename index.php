<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Everfocus Code Challenge</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>

<body>
    <script type="text/javascript">
        function clearAll() {
            $(":text").val("");
            $("input:radio").attr("checked", false);
        }

    </script>

    <div class="container">
        <div id="headerDiv" class="container-fluid">
            <?php
            shell_exec_enabled();
            function shell_exec_enabled() {
                $disabled = explode(', ', ini_get('disable_functions'));
                return !in_array('shell_exec', $disabled);
            }
            ?>
                <h1><?php echo shell_exec('./printHelloworld');?></h1>
        </div>

        <div id="tableDiv" class="table-responsive">

            <?php
    $database = 'employee.csv'; // for locally developing
//    $database = 'gs://everfocus/employee.csv'; // for remote server test
    
    if (isset($_GET['insert'])) { 
        insert_to_database($database); 
    }
    
    $next_id = display_csv($database, "r");
    
    function parse_to_tr($string, $tag_name) {
        if (!$string) {
            return -1;
        }
        
        $html = "";
        
        if ($tag_name == 'th') {
            $array_for_display = array('Name', 'EmployeeNo', 'Gender', 'Department');
        } else {
            $array = str_getcsv($string, $delimiter = ";", $enclosure = '"');
            $array_for_display = array($array[3], $array[2], $array[4], $array[1]);
        }
        
        foreach ($array_for_display as $value) {
            $html .= "<$tag_name>$value</$tag_name>";
        }
        $html = "<tr>$html</tr>";
            
        echo $html;
        return $array[0];
    }
    
    function display_csv($filename) {
        // when reading files either on or created by a Macintosh computer
        ini_set("auto_detect_line_endings", true);
        
        echo '<table class="table table-bordered table-hover">';

        $file = fopen($filename, "r");
        parse_to_tr(fgets($file), "th"); 
        
        $max_id = -1;

        // read one line from csv file in each loop
        while(! feof($file)) {
             $max_id = max(parse_to_tr(fgets($file), "td"), $max_id); 
        }
        fclose($file);

        echo '</table>';
        return $max_id + 1; // return the next valid id (auto-increment)
    }
    
    function insert_to_database($filename) {
        // get values for insertion
        $new_values = array($_GET['department'], $_GET['employeeno'], $_GET['name'], $_GET['gender']);//array_slice($_GET, 0, count($_GET) - 1, true);
        
        // get a formatted string valid for database record
        $new_record = $_GET['id'] . ';"' . implode('";"', $new_values) . "\"\n";
        
        // Write the contents to the file
        file_put_contents($filename, file_get_contents($filename) . $new_record);
    }
    ?>
        </div>

        <div class="col-sm-offset-10 col-sm-2 col-xs-offset-7 col-xs-5">
            <!-- Button trigger modal -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModalNorm">Add record</button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                    New employee info
                </h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form class="form-horizontal" name="form" id="form" method="GET" action="" role="form">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 col-xs-6 control-label">Name</label>
                                <div class="col-sm-10  col-xs-12 ">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Steward" required pattern="^[A-Z][a-z]{1,44}$">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="employeeno" class="col-sm-2 col-xs-6 control-label">EmployeeNo</label>
                                <div class="col-sm-10 col-xs-12">
                                    <input type="text" name="employeeno" id="employeeno" class="form-control" placeholder="0000000001" required pattern="^\d{1,20}$">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="col-sm-2 col-xs-6 control-label">Gender</label>
                                <div class="radio col-sm-10 col-xs-12">
                                    <label>
                                        <input type="radio" name="gender" value="Male" required> Male
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="gender" value="Female"> Female
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="department" class="col-sm-2 col-xs-6 control-label">Department</label>
                                <div class="col-sm-10 col-xs-12">
                                    <input type="text" name="department" id="department" class="form-control" placeholder="Engineer" required pattern="^[a-zA-Z\s]{1,45}$">
                                </div>
                            </div>

                            <input type="hidden" name="id" value="<?php echo $next_id;?>">
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <div>
                            <input type="button" value="Clear" class="btn btn-default" onclick="clearAll()">
                            <input form="form" type="submit" name="insert" class="btn btn-primary" id="submit" value="Insert" autofocus>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
