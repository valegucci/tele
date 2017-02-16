<?php 

class R4ME_Query{
	private $args = array();
	private $action;
	private $result;

	public function __construct($args, $action="SELECT") {
		$this->args = $args;
		$this->action = $action;
		$this->result = $this->r4me_vendors();
	}

	private function r4me_vendors(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection(); 
		$args = $this->args;
		if($this->action === 'DELETE'){
			$sql = $this->action . " FROM r4me_vendors ";
		}elseif($this->action === 'COUNT'){
			$sql ="SELECT SQL_CALC_FOUND_ROWS(id) FROM r4me_vendors ";
		}else{
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM r4me_vendors ";
		}
		
		$size = $integrated = $vendor = $vendorId = $search = $id = $country = '';
		if(isset($args['size'])){
			$size = $args['size'];
		}
		if(isset($args['is_integrated'])){
			$integrated = $args['is_integrated'];
		}
		if(isset($args['vendor'])){
			$vendor = $args['vendor'];
		}
		if(isset($args['vendor_id'])){
			$vendorId = $args['vendor_id'];
		}
		if(isset($args['search'])){
			$search = $args['search'];
		}
		if(isset($args['id'])){
			$id = $args['id'];
		}
		if(isset($args['country'])){
			$country = $args['country'];
		}
		if(isset($args['feature'])){
			$feature = $args['feature'];
		}


		if(!empty($search)){
			$sql .= (strpos($sql, 'WHERE') !== false ? 'AND' : 'WHERE')  . " slug LIKE '%$search%'";
		}

		if(!empty($id)){
			$sql .= (strpos($sql, 'WHERE') !== false ? 'AND' : 'WHERE')  . " id = '$id'";
		}

		if(!empty($size)){
			$sql .= (strpos($sql, 'WHERE') !== false ? 'AND' : 'WHERE')  . " size = '$size'";
		}

		if(!empty($integrated)){
			$sql.= (strpos($sql, 'WHERE') !== false ? 'AND' : 'WHERE') . " is_integrated = '$integrated'";
		}	

		if(!empty($vendor)){
			$sql.= (strpos($sql, 'WHERE') !== false ? 'AND' : 'WHERE') . " slug = '$vendor'";
		}elseif(!empty($vendorId)){
			$sql.= (strpos($sql, 'WHERE') !== false ? 'AND' : 'WHERE') . " id = '$vendorId'";
		}

		if(!empty($country)){

			$country_id = r4me_get_country_by_code($country);
			if((int)$country_id > 0){
				$sql .= (strpos($sql, 'WHERE') !== false ? 'AND' : 'WHERE') . " id in (SELECT vendor_id FROM r4me_vendor_country_relationship WHERE country_id = '$country_id')";
			}
		}


		if(!empty($feature)){
			$feature_id = r4me_get_feature_by_slug($feature);
			$sql .= (strpos($sql, 'WHERE') !== false ? 'AND' : 'WHERE') . " id in (SELECT vendor_id FROM r4me_vendor_feature_relationship WHERE feature_id = '$feature_id')";
		}

		$sql .=" ORDER BY id DESC";	

		if(isset($args['page']) && $this->action !== 'COUNT'){
			$page = $args['page'];
			$per_page = 48;
			if(isset($args['vendors_per_page'])){
				$per_page = $args['vendors_per_page'];
			}
			$start = ($page-1) * $per_page;

			$sql .=" LIMIT $start, $per_page";	
		}

		if(isset($args['limit']) && is_int($args['limit'])){
			$limit = $args['limit'];
			$sql .=" LIMIT $limit";	
		}


		return $mysqli->query($sql);
	}

	public function has_vendors(){
		if(isset($this->result->num_rows) && $this->result->num_rows > 0) return true;
		return false;
	}

	public function get_vendors(){
		return $this->result->fetch_assoc();
	}

	public function count_vendors(){
		return isset($this->result->num_rows) ? $this->result->num_rows : 0;
	}
}