<?
    /* 
     * The thumbnail function uses the pnmscale program from
     * the popular Netpbm image manipulation tools package
     * to create a thumbnail of the given image.  If a thumbnail
     * already exists for the image, the function simply returns.
     */
     
    function thumbnail($filename,$twidth,$theight,$forder) {

        /* Define where to find the various external binaries we need      */
        $djpeg = "/usr/bin/djpeg"; /* decompresses a jpeg to ppm     */ 
        $cjpeg = "/usr/bin/cjpeg"; /* compreses a ppm to jpeg format */
        $pnmscale = "/usr/bin/pnmscale"; /* scales a ppm image    */
        $giftopnm = "/usr/bin/giftopnm"; /* convert a gif to ppm  */
        $ppmtogif = "/usr/bin/ppmtogif"; /* convert a ppm to gif  */
        $ppmquant = "/usr/bin/ppmquant"; /* colour quantize a ppm */

		

  		$tdir = $forder; /* thumbnail directory   */
        if(!filetype($tdir)) {
            if(!@mkdir($tdir,0707)) {
                echo "Unable to create $tdir dir - check permissions<br>\n";
                return;
            }
        }
        

        $user_file_arr = explode('/',$filename);
        $userfile_name = $user_file_arr[count($user_file_arr)-1];
        
//        echo $userfile_name;exit;

        $tfile = $tdir . "/" . $twidth . "x" . $theight . "_" . $userfile_name;   /* thumbnail file       */

//        if(!filesize($tfile)) {
            if(ereg("\.gif$",$userfile_name) || ereg("\.GIF$",$userfile_name)) {  /* Look for .gif extension     */
                exec("$giftopnm $filename | $pnmscale -width $twidth -height $theight | $ppmquant 256 | $ppmtogif -interlace > $tfile");
                //echo "$giftopnm $filename | $pnmscale -width $twidth -height $theight | $ppmquant 256 | $ppmtogif -interlace > $tfile";
            } elseif(ereg("\.jpeg",$userfile_name) || ereg("\.jpg",$filename) || ereg("\.JPG",$filename) || ereg("\.JPEG",$filename)) { /* Look for .jpg or .jpeg */
            	//echo "$djpeg $filename | $pnmscale -width $twidth -height $theight | $cjpeg -outfile $tfile";exit;
                exec("$djpeg $filename | $pnmscale -width $twidth -height $theight | $cjpeg -outfile $tfile");
                
            } else {  /* not a GIF or JPG file */
                return("");
            }
//        }
		
		//exit;
        return($tfile);
    }
?>
