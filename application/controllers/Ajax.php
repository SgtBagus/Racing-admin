<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function get_team($id){
		$team = $this->mymodel->selectWithQuery("SELECT a.team_id as team_id, b.name as name FROM tbl_event_register a INNER JOIN tbl_team b ON a.team_id = b.id WHERE a.approve = 'APPROVE' AND a.event_id = " . $id);
		echo json_encode($team);
	}

	public function get_rider($id){
		$rider = $this->mymodel->selectWithQuery("SELECT a.raider_id as raider_id FROM tbl_event_register_raider a INNER JOIN tbl_event_register b ON a.event_register_id = b.id WHERE b.approve = 'APPROVE' AND b.event_id = " . $id);
		echo json_encode($rider);
	}
}