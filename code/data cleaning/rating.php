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
for($i=1;$i<=50000;$i++){
	if($i<=15000){
		$sql="SELECT ArticleID FROM filtered WHERE Category='politics' OR Category='us' OR Category='world' OR Category='opinion' ORDER BY RAND() LIMIT 10 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(0,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
		$sql="SELECT ArticleID FROM filtered WHERE Category!='' ORDER BY RAND() LIMIT 10 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(0,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
	}
	
	if($i>15000 && $i<=30000){
		$sql="SELECT ArticleID FROM filtered WHERE Category='health' OR Category='tech' OR Category='showbiz' OR Category='travel' OR Category='living' ORDER BY RAND() LIMIT 10 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(0,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
		$sql="SELECT ArticleID FROM filtered WHERE Category!='' ORDER BY RAND() LIMIT 10 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(0,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
	}

	if($i>30000 && $i<=35000){
		$sql="SELECT ArticleID FROM filtered WHERE Category='sport' ORDER BY RAND() LIMIT 10 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(0,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
		$sql="SELECT ArticleID FROM filtered WHERE Category!='' ORDER BY RAND() LIMIT 10 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(0,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
	}

	if($i>35000 && $i<=40000){
		$sql="SELECT ArticleID FROM filtered WHERE Category='business' ORDER BY RAND() LIMIT 10 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(0,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
		$sql="SELECT ArticleID FROM filtered WHERE Category!='' ORDER BY RAND() LIMIT 10 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(0,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
	}

	if($i>40000){
		$sql="SELECT ArticleID FROM filtered WHERE Category!='' ORDER BY RAND() LIMIT 20 ";
		$rec=ExecuteGetRows($sql);
		for($j=0;$j<count($rec);$j++){
			$rating=rand(1,10);
			$write.=$i.",".$rec[$j]['ArticleID'].",".$rating."\n";
		}
	}

}
	$fh = fopen("rating.csv", 'w') or die("can't open file");
	fwrite($fh, $write);
	fclose($fh);
?>