<html> 
<?php 
 
ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

	$email = trim($_POST["email"]);
	$phone = trim($_POST["phone"]);
	$birthday = trim($_POST["phone"]);
	$address = trim($_POST["address"]);
	$name = trim($_POST["name"]);
	$country = trim($_POST["country"]);
	$city = trim($_POST["city"]);

	$missing = array();
	
	if($email == null) {
		
		$missing[] = 'email';
	}
	if($phone == null) {
		
		$missing[] = 'phone';
	}
	if($birthday  == null) {
		
		$missing[] = 'birthday';
	}
	if($address == null) {
		
		$missing[] = 'address';
	}
	if($name == null) {
		
		$missing[] = 'name';
	}
	if($country == null) {
		
		$missing[] = 'country';
	}
	if($city == null) {
		
		$missing[] = 'city';
	}

	if(!empty($missing)) {
		echo 'missing data <br />';

		foreach($missing as $m) {
			echo "$m<br />";
	}}

	if ($c = oci_connect ("ora_m2a0b", "a21498143", "ug")) {

		$jobSeeker = "insert into jobSeeker values($email, $phone, $birthday, $address, $name, $country, $city)";


		if ($js = oci_parse($c, $jobSeeker)) {
    			echo "New record created successfully";
		} else {
    			echo "Error: " . $jobSeeker . "<br>" . $c->error;
		}		

		oci_execute($js);
		oci_fetch_all($s, $row);

		echo "<br>Got data from table tab1:<br>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th></tr>";

		while ($row = oci_fetch_Array($js, OCI_BOTH)) {
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
 	name:<br>
    <input type="text" name="name">
     <br>
     Email:<br>
    <input type="text" name="email">
   <br>
     Address:<br>
    <input type="text" name="address">
   <br>
     City:<br>
    <input type="text" name="city">
   <br>
     Province:<br>
    <input type="text" name="lastname">
   <br>
     Country:<br>
    <input type="text" name="country">
   <br>
     Birthday:<br>
    <input type="text" name="birthday">
   <br>
     Phone Number:<br>
    <input type="text" name="phone">
   <br>
	</p>

	<p>
		<input type="submit" name="submit" value="send"/>
	</p>
</form>


</body>

</html>