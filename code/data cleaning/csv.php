<?php 
set_time_limit(0);
function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

$con=mysql_connect("localhost","root","");
$db=mysql_select_db("239",$con);

$directory = "C:\\wamp\\www\\239\\finale\\";

if ( ! is_dir($directory)) {
    exit('Invalid diretory path');
}

$files = array();

foreach (scandir($directory) as $file) {
    if ('.' === $file) continue;
    if ('..' === $file) continue;
 $files[] = $file;
}
echo count($files);
//var_dump($files);
$arr=array();
$content="";
$cnt=0;
for($j=0;$j<count($files);$j++){
    $body=file_get_contents($directory.$files[$j]);
	$con=explode("^_^",$body);
	$cat=explode("_",$files[$j]);
	
	//$title=explode("By",$con[2]);
	$title=$con[2];
	 //echo $files[$j]."-".$con[2]."<br/>"; 
	// $query="SELECT * FROM articles WHERE Title='".addslashes(trim($title[0]))."'";
	// $res=mysql_query($query);
	$gtitle=$title;
	 if($arr["'".addslashes(trim($gtitle))."'"]==''){$arr["'".addslashes(trim($gtitle))."'"]=1;$count=0; }else{$count=1;echo "same: $gtitle<br/>";}
	 
	 if($count==0){
		 echo $cnt;
	//echo "<br/>";
	 echo $sql="INSERT INTO articles (Title, Category, File) VALUES ('".addslashes(trim($gtitle))."','".$cat[0]."','".$files[$j]."');"; //exit;
	echo "<br/>";
		mysql_query($sql);
		 $cnt++;
	 }
	// exit;
	}


//echo $final;

?>