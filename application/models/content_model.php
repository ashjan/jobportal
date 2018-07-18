<?php
class Content_model extends CI_Model {
   public function get_content_categories(){
   		$tblname = $this->db->dbprefix('tbl_content_category'); //is tbl name
		$query_content_categories = $this->db->query('
								  SELECT
								  id,
								  category_title as category_name,
								  category_slug as pm_id
								  FROM 
								  '.$tblname.'
								  ORDER BY category_title ASC 
								  ');
		if($query_content_categories->num_rows() > 0){
			$row_content_categories = $query_content_categories->result();
			return $row_content_categories;
		}else{
			return "CATEGORIES_NOT_FOUND";
		}
   }
}
?>