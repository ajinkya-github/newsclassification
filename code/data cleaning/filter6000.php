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
$sql="SELECT * FROM articles WHERE Category='politics' ";
$pol=ExecuteGetRows($sql);
//echo count($pol);
$sql="SELECT * FROM articles WHERE Category='us' ";
$us=ExecuteGetRows($sql);

$sql="SELECT * FROM articles WHERE Category='world' ";
$wor=ExecuteGetRows($sql);

$sql="SELECT * FROM articles WHERE Category='opinion'";
$opi=ExecuteGetRows($sql);

for($i=0;$i<876;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$pol[$i]['ArticleID']."','".addslashes($pol[$i]['Title'])."','".$pol[$i]['Category']."','".$pol[$i]['File']."')";
	echo $sql.";<br/>";
	mysql_query($sql);
}

/*for($i=0;$i<876;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$us[$i]['ArticleID']."','".addslashes($us[$i]['Title'])."','".$us[$i]['Category']."','".$us[$i]['File']."')";
	mysql_query($sql);
}


for($i=0;$i<876;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$wor[$i]['ArticleID']."','".addslashes($wor[$i]['Title'])."','".$wor[$i]['Category']."','".$wor[$i]['File']."')";
	mysql_query($sql);
}

for($i=0;$i<876;$i++){
	$sql="INSERT INTO filtered (ACID, Title, Category, File) VALUES ('".$opi[$i]['ArticleID']."','".addslashes($opi[$i]['Title'])."','".$opi[$i]['Category']."','".$opi[$i]['File']."')";
	mysql_query($sql);
}
*/?>