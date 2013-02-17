<?php
	function clearData($data,$type = "s"){
	   switch ($data){
	       case "s":
            $data = htmlspecialchars(stripslashes(trim($data)));
           break;
           case "i":
            $data = mysql_real_escape_string(htmlspecialchars(stripslashes(trim(abs($data)))));
	   }
	   return $data;
	}
    
    function stingcut($string,$length){
       //$newstring = explode(" ",$string);
        $newstring = explode("<br>",wordwrap($string,$length,"<br>"));
        $out = $newstring[0];
        if ($out != $string){
            $out = $out."...";
        }
        return $out;
        }
        function smallImage($url,$width,$height){
            $size = getimagesize($url);
            if ($size[0] > $width || $size[1] > $height){
            //width and height
            $time = time();
            $path = "images/avatars/".$time;
            $dst = imagecreatetruecolor($width,$height);
            if (preg_match("[\w+\.(jpg)|(JPG)|(jpeg)|(JPEG)$]",$url)){
                 $src = imagecreatefromjpeg($url);
                imagecopyresampled($dst, $src,0,0,0,0,$width,$height,$size[0],$size[1]);
                imagejpeg($dst,$path.".jpg");
                $newurl = $path.".jpg";
            }
            if (preg_match("[\w+\.(png)|(PNG)$]",$url)){
                 $src = imagecreatefrompng($url);
                imagecopyresampled($dst, $src,0,0,0,0,$width,$height,$size[0],$size[1]);
                imagejpeg($dst,$path.".png");
                $newurl = $path.".png";
            }
            if (preg_match("[\w+\.(gif)|(GIF)$]",$url)){
                 $src = imagecreatefromgif($url);
                imagecopyresampled($dst, $src,0,0,0,0,$width,$height,$size[0],$size[1]);
                imagejpeg($dst,$path.".gif");
                $newurl = $path.".gif";
            }         
            unlink($url);
            }
            else {$newurl=$url;}
            return $newurl;
        }
?>