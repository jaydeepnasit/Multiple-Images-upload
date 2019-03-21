<?php

class config{

	private $DBHOST='localhost';
	private $DBUSER='root';
	private $DBPASS='';
	private $DBNAME='profile';
	public $con;

	public function __construct(){
			$this->con = mysqli_connect($this->DBHOST, $this->DBUSER, $this->DBPASS, $this->DBNAME);
			if(!$this->con){
				return false;
			}
    } 

    public function htmlvalidation($form_data){
			$form_data = trim( stripslashes( htmlspecialchars( $form_data ) ) );
			//$form_data = preg_replace("/'/", '&rsquo;', $form_data);
			$form_data = mysqli_real_escape_string($this->con, trim(strip_tags($form_data)));
			return $form_data;
    }   
    
    public function insert($tblname, $filed_data){

			$query_data = "";

			foreach ($filed_data as $q_key => $q_value) {
				$query_data = $query_data."$q_key='$q_value',";
			}
			$query_data = rtrim($query_data,",");

			$query = "INSERT INTO $tblname SET $query_data";
			$insert_fire = mysqli_query($this->con, $query);
			if($insert_fire){
				return $insert_fire;
			}
			else{
				return false;
			}

    }	
	
	public function select_where($tblname, $condition, $op="AND"){

			$condition_data = "";
			foreach ($condition as $c_key => $c_value) {
				$condition_data = $condition_data."$c_key='$c_value' $op ";
			}
			$condition_data = rtrim($condition_data,"$op ");

			$select = "SELECT * FROM $tblname WHERE $condition_data";
			$select_fire = mysqli_query($this->con, $select);
			if(mysqli_num_rows($select_fire) == 1){
				$select_fetch = mysqli_fetch_assoc($select_fire);
				if($select_fetch){
					return $select_fetch;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}	

    }
    
    public function delete($tblname, $condition, $op='AND'){

			$delete_data = "";

			foreach ($condition as $q_key => $q_value) {
				$delete_data = $delete_data."$q_key='$q_value' $op ";
			}

			$delete_data = rtrim($delete_data,"$op ");		
			$delete = "DELETE FROM $tblname WHERE $delete_data";
			$delete_fire = mysqli_query($this->con, $delete);
			if($delete_fire){
				return $delete_fire;
			}
			else{
				return false;
			}

    }
    
    public function select_order($tblname, $order_filed, $oder_by="ASC"){

			$select = "SELECT * FROM $tblname ORDER BY $order_filed $oder_by";
			$select_fire = mysqli_query($this->con, $select);
			if(mysqli_num_rows($select_fire) > 0){
				$select_fetch = mysqli_fetch_all($select_fire, MYSQLI_ASSOC);
				if($select_fetch){
					return $select_fetch;
				}
				else{
					return false;
				}
			}	
			else{
				return false;
			}

	}

}
?>