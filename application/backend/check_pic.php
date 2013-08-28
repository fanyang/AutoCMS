<?php
if (!isset ($_SESSION)) {
			session_start();
		}
$rand = "";
for ($i = 0; $i < 4; $i++) {
	$rand .= dechex(rand(0, 15));
}
$_SESSION['check_pic'] = $rand;
$im = imagecreatetruecolor(80, 20);

$bg = imagecolorallocate($im, 0, 0, 0);
$white = imagecolorallocate($im, 255, 255, 255);
imagestring($im, 6, rand(5,35), rand(1,4), $rand, $white);

for($i=0;$i<1;$i++)
{
	imageline($im,0,rand(0,20),80,rand(0,20),$white);
	imageline($im,rand(0,80),0,rand(0,80),20,$white);
}

for($i=0;$i<100;$i++)
{
//	imagesetpixel($im,rand()%80,rand()%20,$white);
}


header("Content-type: image/png");
imagejpeg($im);
?>
