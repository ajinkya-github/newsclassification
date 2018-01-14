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
$write='';

$sql="SELECT * FROM filtered";
$rec=ExecuteGetRows($sql);
for($i=1;$i<=count($rec);$i++){
	$write.=$i.",".stripslashes(str_replace(",","",$rec[$i-1]['Title']))."\n";
}

	$fh = fopen("title.csv", 'w') or die("can't open file");
	fwrite($fh, $write);
	fclose($fh);
?>