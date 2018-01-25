<html> 
<?php 
 

ini_set('session.save_path', realpath(dirname($_SERVER['PHP_SELF']) . '/../session'));
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

	$id = trim($_POST["id"]);
	$time = trim($_POST["time"]);
	$type = trim($_POST["type"]);
	$location = trim($_POST["location"]);
	$length = trim($_POST["length"]);
	$date = trim($_POST["date"]);
	$appID = trim($_POST["appID"]);

	$missing = array();
	
	if($id == null) {
		
		$missing[] = 'Id';
	}
	if($time == null) {
		
		$missing[] = 'time';
	}
	if($type  == null) {
		
		$missing[] = 'type';
	}
	if($location  == null) {
		
		$missing[] = 'location';
	}
	if($length  == null) {
		
		$missing[] = 'length';
	}
	if($date  == null) {
		
		$missing[] = 'date';
	}
	if($appID  == null) {
		
		$missing[] = 'appID';
	}

	if(!empty($missing)) {
		echo 'missing data <br />';

		foreach($missing as $m) {
			echo "$m<br />";
	}}

	if ($c = oci_connect ("ora_m2a0b", "a21498143", "ug")) {

		$interview = "insert into Interview values($id, $time, $type, $location, $length, $date, $appID)";


		if ($it = oci_parse($c, $interview)) {
    			echo "New record created successfully";
		} else {
    			echo "Error: " . $interview . "<br>" . $c->error;
		}		

		oci_execute($it);
		oci_fetch_all($s, $row);

		echo "<br>Got data from table tab1:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = oci_fetch_Array($it, OCI_BOTH)) {
			echo "<tr><td>" . $row[0] . "</td></tr>" . $row[1] . "</td><td>". $row[2] . "</td><td>". $row[3] . "</td></tr>"; //or just use "echo $row[0]" 
		}
		echo "</table>";
		
		oci_close($c);
	} else {
		$err = oci_error();
		echo "Oracle Connect Error " . $err['message'];
	}
}

?>

<body>

<form method="post action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<p>
 	ID:<br>
    <input type="text" name="id">
     <br>
     Time:<br>
    <input type="text" name="time">
   <br>
     Type:<br>
    <input type="text" name="type">
   <br>
 Location:<br>
    <input type="text" name="location">
   <br>
 Length:<br>
    <input type="text" name="length">
   <br>
 Date:<br>
    <input type="text" name="date">
   <br>
 ApplicationID:<br>
    <input type="text" name="appID">
   <br>
	</p>

	<p>
		<input type="submit" name="submit" value="send"/>
	</p>
</form>


</body>

</html>