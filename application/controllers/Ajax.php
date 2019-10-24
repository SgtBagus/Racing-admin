<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function get_rider($id){
		$rider = $this->db->get_where('tbl_raider',array('team_id' => $id))->result_array();
		echo json_encode($rider);
	}
}