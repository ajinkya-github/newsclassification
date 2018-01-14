<?php 
set_time_limit(0);
$directory = "C:\\data\\US\\cnn_old\\";
$dir = "C:\\wamp\\www\\239\\cnn_old_processed\\";

/*
Credits: Bit Repository
URL: http://www.bitrepository.com/web-programming/php/extracting-content-between-two-delimiters.html
*/

function extract_unit($string, $start, $end)
{
$pos = strpos($string, $start);

$str = substr($string, $pos);

$str_two = substr($str, strlen($start));

$second_pos = strpos($str_two, $end);

$str_three = substr($str_two, 0, $second_pos);

$unit = trim($str_three); // remove whitespaces
return $unit;
}

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
 $title = extract_unit($body, 'Delicious', 'updated');
 //echo $body;
  $content = extract_unit($body, '--', '»');
 //exit;
$write= "^_^Title^_^";

$write.= strip_tags($title);

$write.= "^_^Story^_^"; //print_r($content);

	$write.= $content;
	$fh = fopen($dir.$files[$j], 'w') or die("can't open file");
	fwrite($fh, $write);
	fclose($fh);
}
?>