<?php 
set_time_limit(0);
$directory = "U:\\data\\new_html\\";
$dir = "C:\\wamp\\www\\239\\finale\\";

if ( ! is_dir($directory)) {
    exit('Invalid diretory path');
}

$files = array();

foreach (scandir($directory) as $file) {
    if ('.' === $file) continue;
    if ('..' === $file) continue;
 $files[] = $file;
}

//var_dump($files);

for($j=0;$j<count($files);$j++){
$body=file_get_contents($directory.$files[$j]);
preg_match("/<h1>(.+?)<\/h1>/", $body, $title);
preg_match_all("/<p(.+?)>(.+?)<\/p>/", $body, $content);

if($title[0]!=""){
$write= "^_^Title^_^";

$write.= strip_tags($title[0]);

$write.= "^_^Story^_^"; //print_r($content);

for($i=0;$i<count($content[2]);$i++){
	$write.= str_replace("(CNN) -- ", "", strip_tags($content[2][$i]));
}
	$fh = fopen($dir.$files[$j], 'w') or die("can't open file");
	fwrite($fh, $write);
	fclose($fh);
}
}
?>