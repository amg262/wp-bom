<html>
<head>
<title>Demo for License Key Class by Abhishek Shukla</title>
</head>
<body style="background-color:#F0F0F0">
<h1>License Key generation</h1>
<p>The mathematical number of unique keys is limited for various lengths.</p>
<?php 
if($_POST['validate']){
	$name=$_POST['client'];
	$software=$_POST['software'];
	$numkeys=$_POST['numkeys']; if($numkeys<1)$numkeys=1; if($numkeys>50000)$numkeys=50000;
	$keylen=$_POST['keylen'];if($keylen<1)$keylen=1; if($keylen>20)$keylen=20;

include("license_key.class.php");

$pass=new license_key();
echo "<h3>Generating $numkeys Random License Keys </h3>
Name: $client   || Software: $software  || KeyLenght: $keylen</a><hr/>";

for($i=0;$i<$numkeys;$i++){
	$pass->keylen=$keylen;
	$key= $pass->codeGenerate($name.$software);
	$j=$i+1;
	echo "$j- $key <br/>";
}
echo "<br/><br/><a href=\"test.php\">Try Another Time</a><br/><br/>";

}else{
?>

<form method="POST">
<table>
<tr>
<td>Keys to generate</td>
<td><select name="numkeys">
		<option value="1">1</option>
		<option value="5" selected>5</option>
		<option value="10">10</option>
		<option value="20">20</option>
		<option value="50">50</option>
		<option value="100">100</option>
		<option value="500">500</option>
		<option value="1000">1000</option>
		<option value="5000">5000</option>
		<option value="10000">10000</option>
		<option value="20000">20000</option>
		<option value="50000">50000</option>
	</select></td>
</tr>
<tr>
<td>Length of Key</td>
<td><select name="keylen">
		<option value="8">8</option>
		<option value="10">10</option>
		<option value="12">12</option>
		<option value="14">14</option>
		<option value="16">16</option>
		<option value="18">18</option>
		<option value="20">20</option>
</select></td>
</tr>
<tr>
<td>Software Name</td>
<td><input type="text" name="software"></input></td>
</tr>
<tr>
<td>Client Name</td>
<td><input type="text" name="client"></input></td>
</tr>
</table>
<input name="validate" type="submit" value="Generate!"/>
</table>
</form>
<?php 
}
?>

</br></br>

<a href="index.html">Back to Home Page</a>
</body>
</html>
