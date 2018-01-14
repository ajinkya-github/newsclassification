<?php 
set_time_limit(0);
$directory = "C:\\wamp\\www\\239\\final\\";
//$dir = "C:\\wamp\\www\\239\\finale\\";

if ( ! is_dir($directory)) {
    exit('Invalid diretory path');
}

$files = array();

foreach (scandir($directory) as $file) {
    if ('.' === $file) continue;
    if ('..' === $file) continue;
 $files[] = $file;
}

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

//var_dump($files);

for($j=0;$j<count($files);$j++){
	$name=$files[$j];
	
    $sql="SELECT * FROM articles WHERE File='".$name."'";
	$f=ExecuteGetRows($sql);
	
	if(count($f)==0){
		unlink($directory.$name);
	}


}
?>