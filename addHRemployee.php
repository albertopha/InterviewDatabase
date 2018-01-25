<html> 
<?php 
 

ini_set('session.save_path', realpath(dirname($_SERVER['PHP_SELF']) . '/../session'));
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

	$id = trim($_POST["id"]);
	$email = trim($_POST["email"]);
	$name = trim($_POST["name"]);

	$missing = array();
	
	if($id == null) {
		
		$missing[] = 'Id';
	}
	if($email == null) {
		
		$missing[] = 'Email';
	}
	if($name  == null) {
		
		$missing[] = 'Name';
	}
	if(!empty($missing)) {
		echo 'missing data <br />';

		foreach($missing as $m) {
			echo "$m<br />";
	}}

	if ($c = oci_connect ("ora_m2a0b", "a21498143", "ug")) {

		$HRemployee = "insert into HRemployee values($id, $email, $name)";


		if ($HR = oci_parse($c, $HRemployee)) {
    			echo "New record created successfully";
		} else {
    			echo "Error: " . $HRemployee . "<br>" . $c->error;
		}		

		oci_execute($HR);
		oci_fetch_all($s, $row);

		echo "<br>Got data from table tab1:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = oci_fetch_Array($HR, OCI_BOTH)) {
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
     Email:<br>
    <input type="text" name="email">
   <br>
     Name:<br>
    <input type="text" name="name">
   <br>
	</p>

	<p>
		<input type="submit" name="submit" value="send"/>
	</p>
</form>


</body>

</html>