<?php
/*  
* there are two main ways of calling a thumbnail create, the fast way 
* 
* $a = new Thumbnail('resource.jpg',150,150,'output_image.jpg',85); 
* note: the manipulations array encased in single quotes
* 
* or the slow way
* 
* $a = new Thumbnail('resource.jpg',200,150,'output_image.jpg');

* $a->create();
* 
* quotes around hex values seem to be optional
* also note: fast calls are error suppressed, whereas slow calls are not 
* (add if($this->thumb_type !== Null) to any function that needs suppressing)
* 
* note also: it is designed to work silently - ie not called from an img src.
* all it does is save a copy to var $destination_file to preserve server resources

*/

class Thumbnail
	{
	function Thumbnail($resource_file, $max_width, $max_height, $destination_file="")
		{
		$this->scr = $resource_file;		// image to be thumbnailed, name of the file

		$this->des = $destination_file;	// thumbnail saved to
		$this->comp = 99;		// compression ration for jpeg thumbnails
		$this->max_w = $max_width;
		$this->max_h = $max_height;

		// calling the compile function
		$this->compile();
				
		}// END FUNCTION ThumbNail
		
		
	function compile()
		{	
		// getimagesize() gets to width, hight and extention of the file
		$this->size = getimagesize($this->scr);
		if(is_array($this->size))
			{
			$this->img_w = $this->size[0];		// gets width
			$this->img_h = $this->size[1];		// gets hight
			$this->img_type = $this->size[2];		// gets type
		
			$this->o = ($this->img_w / $this->max_w);		// width divided by max_width{100}
			//$this->p = ($this->img_h / $this->max_h);		// hight divided by max_height{60}   This is disable when we will not give hight it is adjust able automaticaly if u will give hight u must enable it 
	$this->thumb_w = ($this->o > $this->p) ? $this->max_w : round($this->img_w / $this->p);// width
	$this->thumb_h = ($this->o > $this->p) ? round($this->img_h / $this->o) : $this->max_h;// height
			}
			/*
			1 = GIF, 
			2 = JPG, 
			3 = PNG, 
			4 = SWF, 
			5 = PSD, 
			6 = BMP, 
			*/
		$this->thumb_type = ($this->img_type < 4) ? ($this->img_type < 3) ? ($this->img_type < 2) ? ($this->img_type < 1) ? Null : imagecreatefromgif($this->scr) : imagecreatefromjpeg($this->scr) : imagecreatefrompng($this->scr) : Null;
		
			
		
		if($this->thumb_type !== Null)
		{
			// created thumbnail reference
			$this->new_img = imagecreatetruecolor($this->thumb_w, $this->thumb_h); 
			

			$this->result = imagecopyresampled($this->new_img, $this->thumb_type, 0, 0, 0, 0, $this->thumb_w, $this->thumb_h, $this->img_w, $this->img_h);
		}
		}// END function compile

	
		
	function create()
		{		
		if($this->thumb_type !== Null)
			{		//destination to save file is not equal to null
			if($this->des !== "")
				{
				imagejpeg($this->new_img, $this->des, $this->comp);
				}
			imagedestroy($this->thumb_type);
			imagedestroy($this->new_img);
			}
		}// END function create
	}
?>