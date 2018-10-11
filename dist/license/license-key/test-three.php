<html>
<head>
<title>Demo for License Key Class by Abhishek Shukla</title>
</head>
<body style="background-color:#F0F0F0">
<h1>License Validation for Particular Keys</h1>
<?php 
if($_POST['validate']){
	$name=$_POST['client'];
	$software=$_POST['software'];
	$keys=$_POST['keys'];
	$keyarray=explode("\r\n",$keys);
	$numkeys=count($keyarray);
	define ('LKM_DEBUG','Yes');
	define("TSTART","<table border=\"2\"><tr><th>Name</th><th>Software</th><th>Key</th><th>Validation</th></tr>");
	define("TCLOSE","</table>");
	include("license_key.class.php");
	$pass=new license_key();
	for($i=0;$i<$numkeys;$i++){
		$thiskey=$keyarray[$i];
		$keylen=strlen(str_replace("-","",$thiskey));
		$pass->keylen=$keylen;
		$valid=$pass->codeValidate($thiskey,$name.$software);
		echo "<br/>License Key: $thiskey Length: $keylen Valid: $valid<hr/>";
	}
	echo "<br/><br/><a href=\"test-compare.php\">Try Another Query</a><br/><br/>";
}else{
?>

<form method="POST">
<table>
<tr>
<td>Software Name</td>
<td><input type="text" name="software"></input></td>
</tr>
<tr>
<td>Client Name</td>
<td><input type="text" name="client"></input></td>
</tr>
<tr>
<td>Keys (One in each row)</td>
<td><textarea name="keys"></textarea></td>
</tr>
</table>
<input name="validate" type="submit"/>
</table>
</form>
<?php 
}

?>
<a href="index.html">Back to Home Page</a>
</body>
</html>
