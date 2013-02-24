<?php
	function clearData($data,$type = "s"){
	   switch ($data){
	       case "s":
            $data = mysql_real_escape_string(htmlspecialchars(stripslashes(trim($data))));
           break;
           case "i":
            $data = mysql_real_escape_string(htmlspecialchars(stripslashes(trim(abs($data)))));
	   }
	   return $data;
	}
    
    function stingcut($string,$length){
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
                
            }
            if (preg_match("[\w+\.(png)|(PNG)$]",$url)){
                 $src = imagecreatefrompng($url);
                imagecopyresampled($dst, $src,0,0,0,0,$width,$height,$size[0],$size[1]);
            }
            if (preg_match("[\w+\.(gif)|(GIF)$]",$url)){
                 $src = imagecreatefromgif($url);
                imagecopyresampled($dst, $src,0,0,0,0,$width,$height,$size[0],$size[1]);
            }  
            imagejpeg($dst,$path.".jpg");
            $newurl = $path.".jpg";       
            unlink($url);
            }
            else {$newurl=$url;}
            return $newurl;
        }
       function sql_query($sql,$options = array(),$return=false,$count=false){
            try{
                global $db;
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $obj = $db->prepare($sql);
                $obj->execute($options);
                if ($return == true){
                    if (!$obj) {$myrow = false;}
                    else {$myrow = true;}
                }
                elseif ($count == true){
                    $myrow = $obj->rowCount();
                }
                else {
                  $myrow = $obj->fetch();  
                }                
            }
            catch(PDOException $e){
                $result = "Извините произошла ошибка \"".$e->getMessage()."\" в строке ";
                $result .= $e->getLine();
                $result .= " в файле ";
                $result .= $e->getFile();
                echo $result;
                 file_put_contents('PDOErrors.txt', $result."\n", FILE_APPEND);
            }
            return $myrow;
       }
?>