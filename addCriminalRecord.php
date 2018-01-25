<html> 
<?php 
 
if ($c=OCILogon("ora_m2a0b", "a21498143", "dbhost.ugrad.cs.ubc.ca:1522/ug")) { 
  echo "Successfully connected to Oracle.\n"; 
} else { 
  $err = OCIError(); 
  echo "Oracle Connect Error " . $err['message']; 
} 


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

	$title = trim($_POST["title"]);
	$date = trim($_POST["date"]);
	$email = trim($_POST["email"]);
	$fee = trim($_POST["fee"]);

	$missing = array();
	
	if($title == null) {
		
		$missing[] = 'title';
	}
	if($date == null) {
		
		$missing[] = 'date';
	}
	if($email  == null) {
		
		$missing[] = 'email';
	}
	if($fee == null) {
		
		$missing[] = 'fee';
	}

	if(!empty($missing)) {
		echo 'missing data <br />';

		foreach($missing as $m) {
			echo "$m<br />";
	}}

	if ($c = oci_connect ("ora_m2a0b", "a21498143", "ug")) {

		$criminalrecord = "insert into CriminalRecord values($title, $date, $email, $fee)";


		if ($cr = oci_parse($c, $criminalrecord)) {
    			echo "New record created successfully";
		} else {
    			echo "Error: " . $criminalrecord . "<br>" . $c->error;
		}		

		oci_execute($cr);
		oci_fetch_all($s, $row);

		echo "<br>Got data from table tab1:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = oci_fetch_Array($cr, OCI_BOTH)) {
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
 	Title:<br>
    <input type="text" name="title">
     <br>
     Date:<br>
    <input type="text" name="date">
   <br>
     Email:<br>
    <input type="text" name="email">
   <br>
     Fee:<br>
    <input type="text" name="fee">
   <br>
	</p>

	<p>
		<input type="submit" name="submit" value="send"/>
	</p>
</form>


</body>

</html>