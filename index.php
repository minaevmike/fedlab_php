<?php
$width = 1000;
$height = 1000;
function add_line($gd, $x0, $y0, $x1, $y1, $scale, $color, $width, $height) {
	imageline($gd, round($scale * $x0 + $width / 2), round($height / 2 - $scale * $y0), round($scale *$x1 + $width / 2), round($height / 2 - $scale * $y1), $color);
}

function draw_axis($gd, $width, $hegiht, $color) {
	imageline($gd, $width / 2, 0, $width/2, $hegiht, $color);
	imageline($gd, 0, $hegiht / 2, $width, $hegiht / 2, $color);
}

function draw_center($gd, $x, $y, $color) {
	imagefilledellipse($gd, $x, $y, 3, 3, $color);
}
$host = "127.0.0.1";
$user = "root";
$password = "1";
$scale = 5;
$database_name = "fed";
$link = mysql_connect($host, $user, $password)
        or die("Could not connect : " . mysql_error());
mysql_select_db($database_name) or die ("Could select database: " . mysql_error());
$query = "SELECT * FROM elements";
$elemets = mysql_query($query) or die(mysql_error());
$el = array();
while(($lines = mysql_fetch_row($elemets))) {
	$el[$lines[0]] = array($lines[1], $lines[2], $lines[3]);
}
mysql_free_result($elemets);
$query = "SELECT * from nodes";
$nodes = mysql_query($query) or die(mysql_error());
$no = array();
while($lines = mysql_fetch_row($nodes)) {
	$no[$lines[0]] = array($lines[1], $lines[2]);
}
mysql_free_result($nodes);
mysql_close($link);
$gd = imagecreate($width, $height);
imagesetthickness($gd, 3);
$white = imagecolorallocate($gd, 255,255,255);
$red = imagecolorallocate($gd, 255, 0, 0);
$black = imagecolorallocate($gd, 0, 0, 0);
draw_axis($gd, $width, $height, $black);
//imageline($gd, 0, 0, 20, 20, $red);
//imagesetpixel($gd, 200, 200, $red);
foreach($el as $e) {
add_line($gd, $no[$e[0]][0], $no[$e[0]][1], $no[$e[1]][0], $no[$e[1]][1], $scale, $red, $width, $height);
add_line($gd, $no[$e[1]][0], $no[$e[1]][1], $no[$e[2]][0], $no[$e[2]][1], $scale, $red, $width, $height);
add_line($gd, $no[$e[0]][0], $no[$e[0]][1], $no[$e[2]][0], $no[$e[2]][1], $scale, $red, $width, $height);
draw_center($gd, ($no[$e[0]][0] + $no[$e[1]][0] + $no[$e
}
header("Content-Type: image/png");
imagepng($gd); 
?>
