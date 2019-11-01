<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_team($id)
	{
		$team = $this->mymodel->selectWithQuery("SELECT a.team_id as team_id, b.name as name FROM tbl_event_register a LEFT JOIN tbl_team b ON a.team_id = b.id WHERE a.approve = 'APPROVE' AND a.event_id = " . $id . " GROUP BY a.team_id ORDER BY a.team_id ASC");
		echo json_encode($team);
	}

	public function get_rider($event_id, $id)
	{	
		if($id == ""){
			$rider = $this->mymodel->selectWithQuery("SELECT a.raider_id as raider_id, c.name as nameraider, c.nostart as nostart, d.name as nameteam FROM tbl_event_register_raider a LEFT JOIN tbl_event_register b ON a.event_register_id = b.id LEFT JOIN tbl_raider c ON a.raider_id = c.id LEFT JOIN tbl_team d ON b.team_id = d.id WHERE b.approve = 'APPROVE' AND b.event_id = " . $event_id);
		}else{
			$rider = $this->mymodel->selectWithQuery("SELECT a.raider_id as raider_id, c.name as nameraider, c.nostart as nostart, d.name as nameteam FROM tbl_event_register_raider a LEFT JOIN tbl_event_register b ON a.event_register_id = b.id LEFT JOIN tbl_raider c ON a.raider_id = c.id LEFT JOIN tbl_team d ON b.team_id = d.id WHERE b.approve = 'APPROVE' AND b.event_id = " . $event_id . " AND b.team_id = " . $id);
		}
		echo json_encode($rider);
	}
}
