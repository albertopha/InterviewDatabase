<!DOCTYPE html>
<html>

<head>

<h> Employee </h>

</head>
<?php 
 

ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();

if(!(isset($_SESSION['Employee']))) {
	header("Location: homePage.php");
	
}

echo $_SESSION['Employee'];

if(isset($_POST['submit'])) {
	
	$employeeId = $_POST["user"];
	$employeeemail = $_POST["email"];
	

	$missing = array();
	
	if($employeeId  == null) {
		
		$missing[] = 'employeeId ';
	}
	

	if(!empty($missing)) {
		echo 'missing data <br />';

		foreach($missing as $m) {
			echo "$m<br />";
	}}

	if ($c = oci_connect ("ora_m2a0b", "a21498143", "dbhost.ugrad.cs.ubc.ca:1522/ug")) {


		$query = "select employee_id, employee_email, count(*)  
		from HRemployee 
		group by employee_id, employee_email
		having Count(*)=1 AND employee_id = '$employeeId'AND employee_email = '$employeeemail'";


		if ($e = oci_parse($c, $query)) {
    			echo "New record created successfully";
		} else {
    			echo "Error: " . $query . "<br>" . $c->error;
		}		

		$r = OCIExecute($e, OCI_DEFAULT);
		OCICommit ($c);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $query . "<br>";
		}
		
		$row = OCI_Fetch_Array($e, OCI_BOTH);
		$check = $row[2];
		
		if($check == 1) {
		$_SESSION['Employee'] = '$employeeId';
		header ("Location: Employee.php");
			
	} else {

		$errmsg = "Invalid login. Username or password is incorrect";
	}
		
		oci_close($c);
	} else {
		$err = oci_error();
		echo "Oracle Connect Error " . $err['message'];
	}
	
}

?>
<body>


<p> Actions </p>
<p><a href="reviewLink">Review</a></p>

<p><a href="http://www.ugrad.cs.ubc.ca/~m2a0b/addJob.php">Jobs</a></p>

<p> My account **retrieve the HRemployee info here**</p>

</body>
</html>