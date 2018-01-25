ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();


if(isset($_POST['submit'])) {
	$title = trim($_POST["title"]);
	$date = trim($_POST["date"]);
	$email = trim($_POST["email"]);
	$contactNumber = trim($_POST["contactNumber"]);

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
	if($contactNumber == null) {
		
		$missing[] = 'contactNumber';
	}

	if(!empty($missing)) {
		echo 'missing data <br />';

		foreach($missing as $m) {
			echo "$m<br />";
	}}

	if ($c = oci_connect ("ora_m2a0b", "a21498143", "ug")) {

		$coverletter = "insert into CoverLetter values($title, $date, $email, $contactNumber)";


		if ($cl = oci_parse($c, $coverletter)) {
    			echo "New record created successfully";
		} else {
    			echo "Error: " . $coverletter . "<br>" . $c->error;
		}		

		oci_execute($cl);
		oci_fetch_all($s, $row);

		echo "<br>Got data from table tab1:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = oci_fetch_Array($cl, OCI_BOTH)) {
			echo "<tr><td>" . $row[0] . "</td></tr>" . $row[1] . "</td><td>". $row[2] . "</td><td>". $row[3] . "</td></tr>"; //or just use "echo $row[0]" 
		}
		echo "</table>";
		
		oci_close($c);
	} else {
		$err = oci_error();
		echo "Oracle Connect Error " . $err['message'];
	}
}
echo "$email <br\>";

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
     Contact Number:<br>
    <input type="text" name="contactNumber">
   <br>
	</p>

	<p>
		<input type="submit" name="submit" value="send"/>
	</p>
</form>


</body>

</html>