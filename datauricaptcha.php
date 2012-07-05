<?php


	function getCaptcha() {
		$str = "1,3,4,6,7,9,A,C,D,E,F,H,K,M,N,P,Q,R,T,W,X,Y";
		$list = explode(",", $str);
		$cmax = count($list) - 1;
		$code = '';
		for ( $i=0; $i < 7; $i++ ){
			  $randnum = mt_rand(0, $cmax);
			  $code .= $list[$randnum];
		}

		ob_start();
		$im = @imagecreate (350, 90) or die ("Cannot Initialize new GD image stream");
		$background_color = imagecolorallocate ($im, 0, 0, 0);
		$color = imagecolorallocate ($im, 255,255,255);

		$ylist = @array(400);
		$current = 0;
		$d = 1;
		for($j = 0; $j < 400; $j++) {

		   if($current>10) {
			  $d = -1;
		   } else if($current <-10) {
			  $d = 1;
		   } else if(mt_rand(0, 400) < 200) {
			  $d = -$d;
		   }
		   if(mt_rand(0, 400) < 350) {
			  $current = $current + $d;
		   }

		   $ylist[$j] = $current;
		}

		function imagecharx($img, $char, $x0, $y0,$ylist)
		{
			$da = @imagecreate (10, 20) or die ("Cannot Initialize new GD image stream");
			$background_color = imagecolorallocate ($da, 50, 50, 50);
			$text_color = imagecolorallocate ($da, 255,255,255);
			$color = imagecolorallocate ($img, 255,255,255);
			$arg = rand(0,7)/100.0 * pi();
			imagestring($da, 10, 0, 0, $char, $text_color);
			for($i = 0; $i < 200; $i++) {
				$y = @floor($i/10);
				$x = $i%10;
				$point_color = imagecolorat($da,$x,$y);
        
				if($point_color == $text_color){
					for($j = 0; $j < 7; $j++) {
						$dx = 0; $dy = 0;
						$p = 6;
						for($s = 0; $s < $p; $s++) {
							$dx += rand(0, 1000/$p)/100;
							$dy += rand(0, 1000/$p)/100;
						}
						$xx = $x*5+$dx - 25;
						$yy = $y*5+$dy - 50;
                
						$x1 = cos($arg)*$xx - sin($arg)*$yy + 25;
							$y1 = sin($arg)*$xx + cos($arg)*$yy + 50;
                
						imagesetpixel($img,$x0+$x1,$y0+$y1,$color);
					}
				}
			}
			imagedestroy($da);
		}
		for($j = 0; $j < 800; $j++) {
			 $rx = mt_rand(0, 400);
			 $ry = mt_rand(0, 100);
			 imagesetpixel($im,$rx,$ry,$color);
		}
		for ( $i=0; $i < 7; $i++ ){
			imagecharx($im,substr($code,$i,1),$i*43+25,0,$ylist);
		}

		$current = 0;
		$d = 1;
		for($j = 0; $j < 400; $j+=10) {

		   if($current>30) {
			  $d = -1;
		   } else if($current <-30) {
			  $d = 1;
		   } else if(mt_rand(0, 400) < 70) {
			  $d = -$d;
		   }
		   if(mt_rand(0, 400) < 380) {
			  $current = $current + $d;
		   }

		   for($l = 0; $l < 10; $l++) {
			   $dx = 0; $dy = 0;
			   $p = 2;
			   for($s = 0; $s < $p; $s++) {
					$dx += rand(0, 1000/$p)/100;
					$dy += rand(0, 1000/$p)/100;
			   }
                
			   imagesetpixel($im,$j+$dy,40+$dx+$current,$color);
		   }
		}


		imagepng ($im);
		imagedestroy ($im);
		$gifdata = ob_get_contents();

		ob_end_clean();

		return array( 'question' => 'data:image/gif;base64,'.base64_encode($gifdata), 'answer' => $code );
	}