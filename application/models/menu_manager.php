<?php class Menu_Manager extends CI_Model{
//public $uploaded_provider_image_name;
    function __construct(){
        // Call the Model constructor
		parent::__construct();
		//$this->load->helper(array('form', 'url'));
    }
//  **** Selection Weather Forecast Location from DB *********	
  public function load_weather_forecast(){	
		$tblname = $this->db->dbprefix('weather_forcast');
		$query = $this->db->query('SELECT ' . $tblname . '.weather_forcast FROM ' . $tblname." LIMIT 5");
		if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			//Return default value for Weather Forecast
			return 'Montenegro';
		}
    } 	
//  **** Selection Data from DB *********	
  public function load_specific_content($menu_link){
		//$tblname = $this->db->dbprefix('menu'); //is tbl name
		$tblname_pgcnt = $this->db->dbprefix('tbl_pagecontent'); //is tbl name
		
		
		 $query = $this->db->query("SELECT page_title, description FROM ".$tblname_pgcnt." WHERE id='".$menu_link."'");
								  
		//echo $this->db->last_query();die;
                 $row = $query->result();
				
		return $row;
    }  //  **** Selection Data from DB *********	
   public function load_all_menus(){	
		
	  $tblname = $this->db->dbprefix('tbl_menu');
		$query = $this->db->query('SELECT  * From '.$tblname.' WHERE status = 1');
                //echo $this->db->last_query();
		if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			return FALSE;
		}
	return false;
    } 
    

 //  **** Load All gallery *********	
   public function load_gallery(){	
	  $tblname = $this->db->dbprefix('glry_banner');
		$query = $this->db->query('SELECT  * From '.$tblname.' LIMIT 0, 4');
                if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			return FALSE;
		}
	return false;
    }


    //  **** Load All Services *********	
   public function load_services(){	
	  $tblname = $this->db->dbprefix('services');
		$query = $this->db->query('SELECT  service_name,service_picture,image_path,service_description From '.$tblname.' LIMIT 0, 4');
                if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			return FALSE;
		}
	return false;
    }
    
    
   public function load_product(){ 	
	  $tblname = $this->db->dbprefix('product');
		$query = $this->db->query('Select * From '.$tblname.' LIMIT 0, 4');
                if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			return FALSE;
		}
	return false;
    } 
       public function load_category(){ 	
	  $tblname = $this->db->dbprefix('category');
		$query = $this->db->query('Select * From '.$tblname.' LIMIT 0, 4');
                if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			return FALSE;
		}
	return false;
    } 
    	// Selection data for widget 1
	
public function load_widget1_menus(){
		
	   $tblname2 = $this->db->dbprefix('tbl_menu');
	   $query = $this->db->query('SELECT '
		                          .$tblname2.'.id,'
								  .$tblname2.'.menu_title,'
								  .$tblname2.'.menu_slug,'
								  .$tblname2.'.content_id,'
								  .$tblname2.'.footer_menu
								  FROM '.$tblname2.' WHERE '.$tblname2.'.footer_menu = "widget1" 
								  ORDER BY '.$tblname2.'.menu_order ASC '
								  );

								  
		if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			return FALSE;
		}
    } 
	
	
// Selection data for widget 2
	
public function load_widget2_menus(){
		
	   $tblname2 = $this->db->dbprefix('tbl_menu');
	   $query = $this->db->query('SELECT '
		                          .$tblname2.'.id,'
								  .$tblname2.'.menu_title,'
								  .$tblname2.'.menu_slug,'
								  .$tblname2.'.content_id,'
								  .$tblname2.'.footer_menu
								  FROM '.$tblname2.' WHERE '.$tblname2.'.footer_menu = "widget2" 
								  ORDER BY '.$tblname2.'.menu_order ASC '
								  );

								  
		if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			return FALSE;
		}
    } 
	
	
	// Selection data for widget 3
	
public function load_widget3_menus(){
		
	   $tblname2 = $this->db->dbprefix('tbl_menu');
	   $query = $this->db->query('SELECT '
		                          .$tblname2.'.id,'
								  .$tblname2.'.menu_title,'
								  .$tblname2.'.menu_slug,'
								  .$tblname2.'.content_id,'
								  .$tblname2.'.footer_menu
								  FROM '.$tblname2.' WHERE '.$tblname2.'.footer_menu = "widget3" 
								  ORDER BY '.$tblname2.'.menu_order ASC '
								  );

								  
		if($query->num_rows() > 0){
			$row = $query->result();
			return $row;
		}else{
			return FALSE;
		}
    } 
     
} // Class Pm_afterlogin   ends here