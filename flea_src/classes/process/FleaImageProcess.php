<?php
   /* commend: 
    *     resize
    *     convert height.jpg[0] -thumbnail 900x900 -quality 90 height_output.jpg
    *     sqare 寬的
    *     convert height.jpg[0] -thumbnail 200x -gravity center -crop 200x200+0+0 -quality 90 height_output4.jpg
    *     sqare 長的
    *     convert height.jpg[0] -thumbnail x200 -gravity center -crop 200x200+0+0 -quality 90 height_output3.jpg
    *     sqare 挖出來
    *     convert height.jpg[0] -thumbnail x200 -thumbnail '200x<' -gravity center -crop 200x200+0+0 -quality 90 height_output2.jpg
    *     convert input.jpg -thumbnail x200 -resize '200x<' -resize 50% -gravity center -crop 100x100+0+0 +repage -format jpg -quality 91 square.jpg
    */
class FleaImageProcess{
    //成員函數

    
    //建構子
    function __construct(){

    }
    
    function createUserIconSquare($file_path,$user_id,$subname,$size){
        list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$user_id.$subname);
        if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname."[0] -thumbnail ".$size."x -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."s".$subname);
        }else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname."[0] -thumbnail x".$size." -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."s".$subname);
        } 
    }
    
    /*function createUserIconResize($file_path,$user_id,$subname,$size){
        shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname." -resize ".$size."x".$size."\> -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."r".$subname);
    }*/
    function createUserIconResize($file_path,$user_id,$subname,$size){
        //list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$user_id.$subname);
        //if($height>$width){
            //shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname."[0] -thumbnail ".$size."X -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."r".$subname);
        //}else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."r".$subname);
        //} 
    }
    function createUserIconResizeW($file_path,$user_id,$subname,$size){
        //list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$user_id.$subname);
        //if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname."[0] -thumbnail ".$size."X -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."w".$subname);
        //}else{
            //shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."r".$subname);
        //} 
    }
    
    function createItemIconSquare($file_path,$file_name,$subname,$size){
        list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$file_name.$subname);
        if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail ".$size."x -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."s.png");
        }else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail x".$size." -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."s.png");
        } 
    }
    
    /*function createItemIconResize($file_path,$file_name,$subname,$size){
        shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname." -resize ".$size."x".$size."\> -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
    }*/
    function createItemIconResize($file_path,$file_name,$subname,$size){
        //list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$file_name.$subname);
        //if($height>$width){
            //shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail ".$size."X -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
        //}else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
        //}
    }
    function createItemIconResizeW($file_path,$file_name,$subname,$size){
        //list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$file_name.$subname);
        //if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail ".$size."X -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."w.png");
        //}else{
            //shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
        //}
    }
    
    function createSItemIconSquare($file_path,$file_name,$subname,$size){
        list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$file_name.$subname);
        if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail ".$size."x -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."s.png");
        }else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail x".$size." -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."s.png");
        } 
    }
    
    /*function createSItemIconResize($file_path,$file_name,$subname,$size){
        shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname." -resize ".$size."x".$size."\> -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
    }*/
    function createSItemIconResize($file_path,$file_name,$subname,$size){
        //list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$file_name.$subname);
        //if($height>$width){
            //shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail ".$size."X -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
        //}else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
        //}
    }
    function createSItemIconResizeW($file_path,$file_name,$subname,$size){
        //list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$file_name.$subname);
        //if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail ".$size."X -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."w.png");
        //}else{
            //shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
        //}
    }
    
    function getHeight($source_file){
        return shell_exec('/usr/local/bin/identify -format "%[height]" '.$source_file);
        
    }
    function getWidth($source_file){
        return shell_exec('/usr/local/bin/identify -format "%[width]" '.$source_file);
    }
    
   /* function createUserIconResize($file_path,$user_id,$subname,$size){
        list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$user_id.$subname);
        if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname."[0] -thumbnail ".$size."X -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."r".$subname);
        }else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$user_id.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$user_id.'_'.$size."r".$subname);
        } 
    }
    
    function createItemIconSquare($file_path,$file_name,$subname,$size){
        list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$file_name.$subname);
        if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail ".$size."x -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."s.png");
        }else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail x".$size." -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."s.png");
        } 
    }
    
    function createItemIconResize($file_path,$file_name,$subname,$size){
        list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$file_name.$subname);
        if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail ".$size."X -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
        }else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$file_name.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$file_name.'_'.$size."r.png");
        }
    }*/
    
    function createBoxCoverSquare($file_path,$box_id,$subname,$size){
        list($width, $height, $type, $attr)=getimagesize($file_path.'/'.$box_id.$subname);
        if($height>$width){
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$box_id.$subname."[0] -thumbnail ".$size."x -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$box_id.'_'.$size."s".$subname);
        }else{
            shell_exec("/usr/local/bin/convert ".$file_path.'/'.$box_id.$subname."[0] -thumbnail x".$size." -gravity center -crop ".$size."x".$size."+0+0 +repage -quality 100 -colorspace RGB ".$file_path.'/'.$box_id.'_'.$size."s".$subname);
        } 
    }
    
    function createBoxCoverResize($file_path,$box_id,$subname,$size){
        shell_exec("/usr/local/bin/convert ".$file_path.'/'.$box_id.$subname."[0] -thumbnail x".$size." -quality 100 -colorspace RGB ".$file_path.'/'.$box_id.'_'.$size."r".$subname);
    }
    
    function removeBack($file_path,$item_path,$item_id){
        $command_stirng = "/usr/local/bin/convert ".$file_path." \( +clone -fx 'p{0,0}' \) -compose Difference  -composite -modulate 100,0  -alpha off  ".$item_path."/difference.png;";
        $command_stirng .= "/usr/local/bin/convert ".$item_path."/difference.png -bordercolor black -border 5 -threshold 10%  -blur 0x3  ".$item_path."/halo_mask.png;";
        $command_stirng .= "/usr/local/bin/convert ".$file_path." -bordercolor white -border 5  ".$item_path."/halo_mask.png -alpha Off -compose CopyOpacity -composite ".$item_path."/".$item_id.".png";
        //shell_exec("/usr/local/bin/convert ".$file_path." \( +clone -fx 'p{0,0}' \) -compose Difference  -composite -modulate 100,0  -alpha off  ".$item_path."/difference.png");
        //shell_exec("/usr/local/bin/convert ".$item_path."/difference.png -bordercolor black -border 5 -threshold 10%  -blur 0x3  ".$item_path."/halo_mask.png");
        //shell_exec("/usr/local/bin/convert ".$file_path." -bordercolor white -border 5   halo_mask.png -alpha Off -compose CopyOpacity -composite  ".$item_path."/".$item_id.".png");
        shell_exec($command_stirng);
    }
    
    //解構子 程式執行完畢 物件會自動消滅
    function __destruct(){
    }
   
}
?>