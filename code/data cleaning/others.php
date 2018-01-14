<?php 
function ExecuteGetRows($sql)
{
 $sqlquery=$sql;
 $executes=mysql_query($sqlquery);
 $i=0;
 $result=array();
 while($res=mysql_fetch_assoc($executes))
 {
   $result[$i]=$res;
   $i++;
 }
 return $result;
}

set_time_limit(0);
function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

$con=mysql_connect("localhost","root","");
$db=mysql_select_db("239",$con);
//politics, Us , world, opinion 3500
//others 3000

//business- 399
//health, living,  showbiz, sport, tech, travel,- 434
$sql="SELECT * FROM articles WHERE Category='business' ";
$bus=ExecuteGetRows($sql);
//echo count($pol);
$sql="SELECT * FROM articles WHERE Category='health' ";
$hea=ExecuteGetRows($sql);

$sql="SELECT * FROM articles WHERE Category='living' ";
$liv=ExecuteGetRows($sql);

$sql="SELECT * FROM articles WHERE Category='showbiz'";
$sho=ExecuteGetRows($sql);

$sql="SELECT * FROM articles WHERE Category='sport'";
$spo=ExecuteGetRows($sql);

$sql="SELECT * FROM articles WHERE Category='tech'";
$tec=ExecuteGetRows($sql);

$sql="SELECT * FROM articles WHERE Category='travel'";
$tra=ExecuteGetRows($sql);

for($i=0;$i<358;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$bus[$i]['ArticleID']."','".addslashes($bus[$i]['Title'])."','".$bus[$i]['Category']."','".$bus[$i]['File']."')";
	//echo $sql."<br/>";
	mysql_query($sql);
}

for($i=0;$i<358;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$hea[$i]['ArticleID']."','".addslashes($hea[$i]['Title'])."','".$hea[$i]['Category']."','".$hea[$i]['File']."')";
	mysql_query($sql);
}

for($i=0;$i<358;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$liv[$i]['ArticleID']."','".addslashes($liv[$i]['Title'])."','".$liv[$i]['Category']."','".$liv[$i]['File']."')";
	mysql_query($sql);
}

for($i=0;$i<358;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$sho[$i]['ArticleID']."','".addslashes($sho[$i]['Title'])."','".$sho[$i]['Category']."','".$sho[$i]['File']."')";
	mysql_query($sql);
}

for($i=0;$i<358;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$spo[$i]['ArticleID']."','".addslashes($spo[$i]['Title'])."','".$spo[$i]['Category']."','".$spo[$i]['File']."')";
	mysql_query($sql);
}


for($i=0;$i<358;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$tec[$i]['ArticleID']."','".addslashes($tec[$i]['Title'])."','".$tec[$i]['Category']."','".$tec[$i]['File']."')";
	mysql_query($sql);
}


for($i=0;$i<358;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$tra[$i]['ArticleID']."','".addslashes($tra[$i]['Title'])."','".$tra[$i]['Category']."','".$tra[$i]['File']."')";
	mysql_query($sql);
}
?>