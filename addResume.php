<html> 
<?php 
 
ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

	$title = trim($_POST["title"]);
	$email = trim($_POST["email"]);
	$date = trim($_POST["date"]);
	$award = trim($_POST["award"]);

	$missing = array();
	
	if($title == null) {
		
		$missing[] = 'title';
	}
	if($email == null) {
		
		$missing[] = 'email';
	}
	if($date  == null) {
		
		$missing[] = 'date';
	}
	if($award == null) {
		
		$missing[] = 'award';
	}

	if(!empty($missing)) {
		echo 'missing data <br />';

		foreach($missing as $m) {
			echo "$m<br />";
	}}

	if ($c = oci_connect ("ora_m2a0b", "a21498143", "ug")) {

		$resume = "insert into Resume values($title, $date, $email, $award)";


		if ($r = oci_parse($c, $resume)) {
    			echo "New record created successfully";
		} else {
    			echo "Error: " . $resume . "<br>" . $c->error;
		}		

		oci_execute($r);
		oci_fetch_all($s, $row);

		echo "<br>Got data from table tab1:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = oci_fetch_Array($r, OCI_BOTH)) {
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
     <br>
 	Title:<br>
    <input type="text" name="title">
     <br>
     Date:<br>
    <input type="text" name="date">
   <br>
     Email:<br>
    <input type="text" name="email">
   <br>
     Award:<br>
    <input type="text" name="award">
   <br>
	</p>

	<p>
		<input type="submit" name="submit" value="send"/>
	</p>
</form>


</body>

</html>