<?php

class GDArrow
{

    /**
     * The referenced canvas
     */
    public $image;

    /**
     * Arrow color
     */
    public $color;

    /**
     * X-Coordinate of arrow's starting point
     */
    public $x1;

    /**
     * Y-Coordinate of arrow's starting point
     */
    public $y1;

    /**
     * X-Coordinate of arrow's endpoint
     */
    public $x2;

    /**
     * Y-Coordinate of arrow's starting point
     */
    public $y2;

    /**
     * Arm angle of the arrowhead
     */
    public $angle;

    /**
     * Length of the arrowhead
     */
    public $radius;


    /**
     * The constructor
    */
    function __construct() {}


	/**
     * Draws the arrow according the given parameters
     */
	function drawGDArrow() {

        $l_m = null;
        $l_x1 = null;
        $l_y1 = null;
        $l_x2 = null;
        $l_y2 = null;
        $l_angle1 = null;
        $l_angle2 = null;
        $l_cos1 = null;
        $l_sin1 = null;

        // Draws the arrow's line
		Imageline($this -> image, $this -> x1, $this -> y1, $this -> x2, $this -> y2, $this -> color);
        
        // Gradient infinite?
		if ($this -> x2 == $this -> x1) {

			$l_m = FALSE;

			if ($this -> y1 < $this -> y2) {

				$l_x1 = $this -> x2 - $this -> radius * sin(deg2rad($this -> angle));
				$l_y1 = $this -> y2 - $this -> radius * cos(deg2rad($this -> angle));
				$l_x2 = $this -> x2 + $this -> radius * sin(deg2rad($this -> angle));
				$l_y2 = $this -> y2 - $this -> radius * cos(deg2rad($this -> angle));

			} else {

				$l_x1 = $this -> x2 - $this -> radius * sin(deg2rad($this -> angle));
				$l_y1 = $this -> y2 + $this -> radius * cos(deg2rad($this -> angle));
				$l_x2 = $this -> x2 + $this -> radius * sin(deg2rad($this -> angle));
				$l_y2 = $this -> y2 + $this -> radius * cos(deg2rad($this -> angle));

			} // endelse

		} // endif $this -> x2 == $this -> x1

        // Gradient = 0
		elseif ($this -> y2 == $this -> y1) {
            
			$l_m = 0;

			if ($this -> x1 < $this -> x2) {

				$l_x1 = $this -> x2 - $this -> radius * cos(deg2rad($this -> angle));
				$l_y1 = $this -> y2 - $this -> radius * sin(deg2rad($this -> angle));
				$l_x2 = $this -> x2 - $this -> radius * cos(deg2rad($this -> angle));
				$l_y2 = $this -> y2 + $this -> radius * sin(deg2rad($this -> angle));

			} else {

				$l_x1 = $this -> x2 + $this -> radius * cos(deg2rad($this -> angle));
				$l_y1 = $this -> y2 + $this -> radius * sin(deg2rad($this -> angle));
				$l_x2 = $this -> x2 + $this -> radius * cos(deg2rad($this -> angle));
				$l_y2 = $this -> y2 - $this -> radius * sin(deg2rad($this -> angle));

			}

		} // endif $this -> y2 == $this -> y1

        // Gradient positive?
		elseif ($this -> x2 > $this -> x1) {

			// Calculate gradient
			$l_m = (($this -> y2 - $this -> y1) / ($this -> x2 - $this -> x1));

			// Convert gradient (= Arc tangent(m)) from radian to degree
			$l_alpha = rad2deg(atan($l_m));

			// Right arm angle = gradient + 180 + arm angle
			$l_angle1 = $l_alpha + $this -> angle + 180;
			// Left arm angle = gradient + 180 - arm angle
			$l_angle2 = $l_alpha - $this -> angle + 180;

			// Right arm angle of arrowhead
			// Abscissa = cos(gradient + 180 + arm angle) * radius
			$l_cos1 = $this -> radius * cos(deg2rad($l_angle1));
			$l_x1 = $this -> x2 + $l_cos1;

			// Ordinate = sin(gradient + 180 + arm angle) * radius
			$l_sin1 = $this -> radius * sin(deg2rad($l_angle1));
			$l_y1 = $this -> y2 + $l_sin1;

			// Left arm angle of arrowhead
			$RCos2 = $this -> radius * cos(deg2rad($l_angle2));
			$RSin2 = $this -> radius * sin(deg2rad($l_angle2));

			$l_x2 = $this -> x2 + $RCos2;
			$l_y2 = $this -> y2 + $RSin2;

		}	// endif $this -> x2 > $this -> x1

        // Gradient negative?
		elseif ($this -> x2 < $this -> x1) {

			$this -> angle = 90 - $this -> angle;

			// Calculate gradient
			$l_m = (($this -> y2 - $this -> y1) / ($this -> x2 - $this -> x1));

			// Convert gradient (= Arc tangent(m)) from radian to degree
			$l_alpha = rad2deg(atan($l_m));

			// Right arm angle = gradient + 180 + arm angle
			$l_angle1 = $l_alpha + $this -> angle + 180;
			// Left arm angle = gradient + 180 - arm angle
			$l_angle2 = $l_alpha - $this -> angle + 180;

			// Right arm angle of arrowhead
			// Abscissa = cos(gradient + 180 + arm angle) * radius
			$l_cos1 = $this -> radius * cos(deg2rad($l_angle1));

			// Ordinate = sin(gradient + 180 + arm angle) * radius
			$l_sin1 = $this -> radius * sin(deg2rad($l_angle1));

			// Left arm angle of arrowhead
			$RCos2 = $this -> radius * cos(deg2rad($l_angle2));
			$RSin2 = $this -> radius * sin(deg2rad($l_angle2));

			$l_x1 = $this -> x2 - $l_sin1;
			$l_y1 = $this -> y2 + $l_cos1;

			$l_x2 = $this -> x2 + $RSin2;
			$l_y2 = $this -> y2 - $RCos2;

		}	// endif $this -> x2 < $this -> x1

		Imageline($this -> image, $l_x1, $l_y1, $this -> x2, $this -> y2, $this -> color);
		Imageline($this -> image, $l_x2, $l_y2, $this -> x2, $this -> y2, $this -> color);

	} // drawGDArrow()

} // class GDArrow


$width = 1000;
$height = 1000;
function add_line($gd, $x0, $y0, $x1, $y1, $scale, $color, $width, $height) {
	imageline($gd, round($scale * $x0 + $width / 2), round($height / 2 - $scale * $y0), round($scale *$x1 + $width / 2), round($height / 2 - $scale * $y1), $color);
}

function draw_axis($gd, $width, $hegiht, $color) {
	imageline($gd, $width / 2, 0, $width/2, $hegiht, $color);
	imageline($gd, 0, $hegiht / 2, $width, $hegiht / 2, $color);
}

function draw_center($gd, $x, $y, $color, $scale, $width, $height) {
	imagefilledellipse($gd, round($scale * $x + $width / 2), round($height / 2 - $scale *$y), 3, 3, $color);
}

function draw_arrow_to_center($gd, $x0, $y0, $color, $scale, $width, $height, $len) {
	$xr = $scale * $x0 + $width / 2;
	$yr = $height / 2 - $scale * $y0;
	$tan = $xr / $yr;
	$al = atan($tan);
	$x1r = $len * cos( pi() / 2 + $al) + $width / 2;
	$y1r = $height / 2 - $scale *$len * sin(pi() / 2 + $al);
	imageline($gd, $xr, $yr, $x1r, $y1r, $color);
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
$le = array();
$max_len = 0;
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
$arrow = new GDArrow();
$arrow -> image = $gd;
$arrow -> color = $black;
$arrow -> x1 = 0;
$arrow -> y1 = 0;
$arrow -> x2 = 140;
$arrow -> y2 = 100;
$arrow -> angle = 25;
$arrow -> radius = 12;
$arrow -> drawGDArrow();
//imageline($gd, 0, 0, 20, 20, $red);
//imagesetpixel($gd, 200, 200, $red);
$i = 0;
foreach($el as $e) {
	add_line($gd, $no[$e[0]][0], $no[$e[0]][1], $no[$e[1]][0], $no[$e[1]][1], $scale, $red, $width, $height);
	add_line($gd, $no[$e[1]][0], $no[$e[1]][1], $no[$e[2]][0], $no[$e[2]][1], $scale, $red, $width, $height);
	add_line($gd, $no[$e[0]][0], $no[$e[0]][1], $no[$e[2]][0], $no[$e[2]][1], $scale, $red, $width, $height);
	$xc = ($no[$e[0]][0] + $no[$e[1]][0] + $no[$e[2]][0]) / 3;
	$yc =  ($no[$e[0]][1] + $no[$e[1]][1] + $no[$e[2]][1]) / 3;
	$len = sqrt($xc * $xc + $yc * $yc);
	if ($len > $max_len) {
		$max_len = $len;
	}
	draw_center($gd, $xc , $yc, $black, $scale, $width, $height); 
	$le[] = array($xc, $yc, $len);
}

foreach($le as $l) {
	draw_arrow_to_center($gd, $l[0], $l[1], $black, $scale, $width, $height, $l[2] / $max_len * 200);
}
header("Content-Type: image/png");
imagepng($gd); 
?>
