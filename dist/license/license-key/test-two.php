<html>
<head>
<title>Demo for License Key Class by Abhishek Shukla</title>
</head>
<body style="background-color:#F0F0F0">
<h1>License Key Validation for character variation</h1>
<?php 
if($_POST['validate']){
	$name=$_POST['client'];
	$software=$_POST['software'];
	$numkeys=$_POST['numkeys']; if($numkeys<1)$numkeys=1; if($numkeys>150)$numkeys=150;
	$keylen=$_POST['keylen'];if($keylen<1)$keylen=1; if($keylen>20)$keylen=20;
define("TSTART","<table border=\"2\"><tr><th>Name</th><th>Software</th><th>Key</th><th>Validation</th></tr>");
define("TCLOSE","</table>");
function trow($name,$software,$key,$pass){
	//$keylen=strlen($key);
	$keyarray=str_split($key);
	$basechar='23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
	//validate original key
	$validation=$pass->codeValidate($key,$name.$software);
	echo "<tr><td>$name</td><td>$software</td><td>$key</td><td>$validation</td></tr>";
	$fvalid=0; $validstr="Yes"; $tested=0;
	//validate partial variations
	$checklen=$pass->initLen();
	$checklen=$pass->keylen;
	for ($i=0;$i<$checklen;$i++){
		$changechr=$keyarray[$i];
		if($changechr<>"-"){
			for ($j=0;$j<32;$j++){
				if($changechr<>$basechar[$j]){
					$keyarray[$i]=$basechar[$j];
					$thiskey=implode("",$keyarray);
					$validation=$pass->codeValidate($thiskey,$name.$software);
					if ($validation==$validstr)$fvalid++;
					echo "<tr><td>$name</td><td>$software</td><td>$thiskey</td><td>$validation</td></tr>";
					$keyarray[$i]=$changechr;$tested++;
				}
			}
		}
	}
	global $tfalse,$ttested;
	$tfalse=$tfalse+$fvalid; 
	$ttested=$ttested+$tested;
	return "Teste $tested keys out of which $fvalid False Validated" ;
}

function trowfull($name,$software,$key,$pass){
	$keylen=strlen($key);
	$keyarray=str_split($key);
	$basechar='23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
	//validate original key
	$validation=$pass->codeValidate($key,$name.$software);
	echo "<tr><td>$name</td><td>$software</td><td>$key</td><td>$validation</td></tr>";
	$fvalid=0; $validstr="Yes"; $tested=0;
	//validate partial variations
	for ($i=0;$i<$keylen;$i++){
		$changechr=$keyarray[$i];
		if($changechr<>"-"){
			for ($j=0;$j<32;$j++){
				if($changechr<>$basechar[$j]){
					$keyarray[$i]=$basechar[$j];
					$thiskey=implode("",$keyarray);
					$validation=$pass->codeValidate($thiskey,$name.$software);
					if ($validation==$validstr)$fvalid++;
					$keyarray[$i]=$changechr;$tested++;
				}
			}
		}
	}
	global $fulltfalse,$fullttested;
	$fulltfalse=$fulltfalse+$fvalid; 
	$fullttested=$fullttested+$tested;
	return "Tested $tested keys out of which $fvalid False Validated" ;
}

include("license_key.class.php");
$pass=new license_key();
$tfalse='';$ttested='';
$fulltfalse='';$fullttested='';

for ($i=0;$i<$numkeys;$i++){
	$pass->keylen=$keylen;
	$key= $pass->codeGenerate($name.$software);
	echo "Name: $name || Software: $software || License Key: $key<hr/>";
	echo TSTART;
	$fvalid=trow($name,$software,$key,$pass);
	//trowfull($name,$software,$key,$pass);
	echo TCLOSE;
	echo "<br/>".$fvalid."<br/>";
}

echo "<hr/>Total $ttested keys Tested out of which $tfalse False Validated" ;
//echo "<hr/>Full Total $fullttested keys Tested out of which $fulltfalse False Validated" ;

echo "<br/><br/><a href=\"test-two.php\">Try Another Query</a><br/><br/>";
}else{
?>

<form method="POST">
<table>
<tr>
<td>Keys to test</td>
<td><select name="numkeys">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="5" selected>5</option>
		<option value="10">10</option>
		<option value="20">20</option>
		<option value="50">50</option>
		<option value="100">100</option>
		<option value="150">150</option>
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
<input name="validate" type="submit"/>
</table>
</form>
<?php 
}

?>
<a href="index.html">Back to Home Page</a>
</body>
</html>
