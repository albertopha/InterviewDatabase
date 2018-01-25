<html>

<?php

ini_set('session.save_path', realpath(dirname($_SERVER['PHP_SELF']) . '/../session'));
session_start();


if(isset($_POST['submit'])) {
 $appId = trim($_POST["appId"]);
 $date = trim($_POST["date"]);
 $reviewed = trim($_POST["reviewed"]);
 $employee_id = trim($_POST["eId"]);
 $js_email = trim($_POST["jsEmail"]);
 $j_Id = trim($_POST["jId"]);
 

 $missing = array();
 
 if($appId == null) {
  
  $missing[] = 'appID';
 }
 if($date == null) {
  
  $missing[] = 'date';
 }
 if($reviewed  == null) {
  
  $missing[] = 'reviewed';
 }
 if($employee_id == null) {
  
  $missing[] = 'employeeID';
 }
 if($js_email == null) {
  
  $missing[] = 'email';
 }
 if($j_Id == null) {
  
  $missing[] = 'JobID';
 }

 if(!empty($missing)) {
  echo 'missing data <br />';

  foreach($missing as $m) {
   echo "$m<br />";
 }}

 if ($c = oci_connect ("ora_m2a0b", "a21498143", "dbhost.ugrad.cs.ubc.ca:1522/ug")) {

  $app = "insert into Application values('$appId', '$date', '$reviewed', '$employee_id', '$js_email', '$j_Id')";
 

  if ($a = oci_parse($c, $app)) {
       echo "<br >New record created successfully";
  } else {
       echo "Error: " . $app . "<br>" . $c->error;
  }

  $r = OCIExecute($a,OCI_DEFAULT);
  OCICommit ($c);
  if (!$r) {
   echo "<br>Cannot execute the following command: " . $app . "<br>";
  }

  oci_close($c);
 } else {
  $err = oci_error();
  echo "Oracle Connect Error " . $err['message'];
 }
}

function printResult($result) {
 echo "<br>Got data from table Application:<br>";
 echo "<table>";
 echo "<tr><th>app_id</th>
    <th>app_date</th>
    <th>app_reviewed</th>
    <th>employee_id</th>
    <th>seeker_email</th>
    <th>job_id</th>
      </tr>";

 while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
  echo "<tr><td>" . $row["app_id"] . "</td>
     <td>" . $row["app_date"] . "</td>
            <td>" . $row["app_reviewed"] . "</td>
     <td>" . $row["employee_id"] . "</td>
      <td>" . $row["seeker_email"] . "</td>
     <td>" . $row["job_id"] . "</td></tr>";
 }
 echo "</table>";

}

if(isset($_POST['retrieve'])) {
 $appId = trim($_POST["appId"]);

 $missing = array();
 
 if($appId == null) {
  
  $missing[] = 'appID';
 }

 if(!empty($missing)) {
  echo 'missing data <br />';

  foreach($missing as $m) {
   echo "$m<br />";
 }}

 if ($c = oci_connect ("ora_m2a0b", "a21498143", "dbhost.ugrad.cs.ubc.ca:1522/ug")) {

  $app = "select * from Application where app_id = $appId";
 

  if ($a = oci_parse($c, $app)) {
       echo "<br >New record created successfully";
  } else {
       echo "Error: " . $app . "<br>" . $c->error;
  }

  $r = OCIExecute($a,OCI_DEFAULT);
  OCICommit ($c);
  if (!$r) {
   echo "<br>Cannot execute the following command: " . $app . "<br>";
  }
  
  printResult($a);

  oci_close($c);
 } else {
  $err = oci_error();
  echo "Oracle Connect Error " . $err['message'];
 }
}

?>
<head>
<style>
body {background-color: rgb(200,200,200);}
input {color: blue;}
P{
    border: 1px solid white;
    padding: 15px;
}
</style>
</head>
<body>
<h1 style="text-align:center;"><b>Adding Application</b></h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 <p>
 <b>ID: </b><br>
    <input type="text" name="appId">
     <br>
     <br>
 <b>Date:</b><br>
    <input type="text" name="date">
   <br>
   <br>
  <b>Reviewed:</b><br>
    <input type="text" name="reviewed">
   <br>
   <br>
  <b>EmpolyeeId: </b><br>
    <input type="text" name="eId">
   <br><br>
     <b>Email: </b><br>
    <input type="text" name="jsEmail">
   <br><br>
     <b>JobId:</b><br>
    <input type="text" name="jId">
   <br>
   <br>
  <input type="submit" name="submit" value="submit"/>

</p>
</form>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 <p>
  <b>AppID:</b><br>
    <input type="text" name="appId">
   <br>
   <br>

  <input type="submit" name="retrieve" value="retrieve"/>
</p>
</form>
<a href="www.google.ca">Help?</a>

</body>

</html>
