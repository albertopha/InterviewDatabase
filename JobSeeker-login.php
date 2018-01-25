<html> 


<?php 
 

ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();


if( isset($_POST['submit'])) {
	
	$email = $_POST["user"];
	$phone = $_POST["phone"];


	$missing = array();
	
	if($email == null) {
		
		$missing[] = 'email';
	}
	

	if(!empty($missing)) {
		echo 'missing data <br />';

		foreach($missing as $m) {
			echo "$m<br />";
	}}
	else{

	if ($c = oci_connect ("ora_m2a0b", "a21498143", "dbhost.ugrad.cs.ubc.ca:1522/ug")) {


		$query = "select seeker_email, phone, seeker_name, count(*) 
		from jobSeeker 
		group by seeker_email, phone, seeker_name
		having Count(*)=1 AND seeker_email = '$email'AND phone = '$phone'";

		
		if ($js = oci_parse($c, $query)) {
    			echo "New record created successfully";
		} else {
    			echo "Error: " . $query . "<br>" . $c->error;
		}		

		$r = OCIExecute($js ,OCI_DEFAULT);
		OCICommit ($c);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $query . "<br>";
		}
		$row = OCI_Fetch_Array($js, OCI_BOTH);
		$check = $row[3];
	
		
		if($check == 1) {
		$_SESSION['login'] = $row[2];
		header ('Location: Job-Seeker.php');
			
	} else {

		$errmsg = "Invalid login. Username or password is incorrect";
	}	
		oci_close($c);
	} else {
		$err = oci_error();
		echo "Oracle Connect Error " . $err['message'];
	}

}}

?>

<body>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  		Email:<input type="text" name="user">
			<br>
		Phone:<input type="text" name="phone">
			<br>
	
		<input type="submit" name="submit" value="submit"/>

</form>


</body>

</html>