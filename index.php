<?php
if (function_exists('mysqli_connect')) {
    echo "mysqli is installed";
  } else {
    echo "Enable Mysqli support in your PHP installation "; 
  }
//placeholder
$output = NULL;

if(isset($_POST['submit'])){
    //connect to db
    $mysqli = new mysqli("localhost","root","","test");

    $make = $_POST['make'];
    $model = $_POST['model'];
    $serial = $_POST['serial'];

    foreach($make AS $key => $value){
        $query = "SELECT id FROM inventory WHERE serial = '" . $mysqli->real_escape_string($serial[$key]) . "' LIMIT 1";
        $resultSet = $mysqli->query($query);

        if($resultSet->num_rows ==0){
            //Preform insert
        }else{
            $output .="This record already exists." . $mysqli->error;
        }
    }

    $mysqli->close();
}
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(e){
        //Variables
        var html = '<p /><div>Make: <input type="TEXT" name="make[]" id="childmake" autocomplete="off"/> Model: <input type="TEXT" name="model[]" id="childmodel" autocomplete="off"/> Serial: <input type="TEXT" name="serial[]" id="childserial" autocomplete="off"/> <a href="#" id="remove">x</a></div>';

        var maxRows = 5;

        var x = 1;
        //Add rows to form
        $("#add").click(function(e){

            if(x <= maxRows){

            $("#container").append(html);
            x++;
            }
        });

        //Remove rows from the form
        $("#container").on('click','#remove',function(e){
            $(this).parent('div').remove();
            x--;
        })

        //Populate values from first row
        $("#container").on('dbclick','#childmake',function(e){
            $(this).val($('#make').val());
        })

        $("#container").on('dbclick','#childmodel',function(e){
            $(this).val($('#model').val());
        })

    });
</script>
</head>

<body>
<form method = "POST">
<div id = "container">
Make: <input type="TEXT" name="make[]" id="make"/>
Model: <input type="TEXT" name="model[]" id="model" />
Serial: <input type="TEXT" name="serial[]" id="serial" />
<a href="#" id="add">Add More</a>
</div>
<p />
<input type="Submit" name="submit" />
</form>
<?php echo $output; ?>
</body>

</html>