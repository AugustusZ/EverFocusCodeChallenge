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
    <?php 
    $dbhost = "173.194.229.44";
    $dbuser = "yankuanz";
    $dbpass = "everfocus";
    $dbname = "employee";
    
    $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to database: " . mysqli_connect_error();
    }
    
    ?>
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
                <!--                <h1><?php echo shell_exec('./printHelloworld');?></h1>-->
                <h1></h1>
        </div>

        <div id="tableDiv" class="table-responsive">

            <?php   
            if (isset($_POST['insert'])) { 
                insert_to_database($db); 
            }
            display_table($db);

            function display_table($db) {
                $query = "SELECT * FROM employee";
                $result = mysqli_query($db, $query);
                if (!$result) {
                    die("Fetching data failed.");
                }
                echo '<table class="table table-bordered table-hover">';
                display_header_row();    
                while ($row = mysqli_fetch_assoc($result)) { // not ==
                    display_data_row($row);
                }
                mysqli_free_result($result); 
                echo "</table>";
            }
            
            function display_data_row($row) {
                $field_names = array('name', 'employeeno', 'gender', 'department');
                $html = "";

                foreach ($field_names as $field_name) {
                    $data_html .= add_tag($row[$field_name], "td");
                }

                echo add_tag($data_html, "tr");
            }

            function display_header_row() {
                $headers = array('Name', 'EmployeeNo', 'Gender', 'Department');
                $header_html = "";

                foreach ($headers as $header) {
                    $header_html .= add_tag($header, "th");
                }

                echo add_tag($header_html, "tr");
            }

            function add_tag($value, $tag_name) {
                return "<$tag_name>$value</$tag_name>";
            }
  
            function insert_to_database($db) {
                // get values for insertion
                $query = "INSERT INTO employee (";
                $query .= "department, employeeno, name, gender";
                $query .= ") VALUES (";
                $query .= "'{$_POST['department']}', '{$_POST['employeeno']}', '{$_POST['name']}', '{$_POST['gender']}'";
                $query .= ")";
                $result = mysqli_query($db, $query);
                if (!$result) {
                    die("Inserting data failed.");
                }
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
                        <form class="form-horizontal" name="form" id="form" method="POST" action="" role="form">
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

<?php 
    mysqli_close($db); 
?>
