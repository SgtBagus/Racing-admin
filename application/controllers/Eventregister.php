<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Eventregister extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Pendaftar Event";
		$data['tbl_event_register'] = $this->mymodel->selectWithQuery('SELECT * FROM tbl_event_register ORDER BY id DESC'); 
		$this->template->load('template/template','eventregister/index', $data);
	}

	public function view($id)
	{
		$data['page_name'] = "Pendaftar Event";
		$data['tbl_event_register'] = $this->mymodel->selectDataone('tbl_event_register', array('id' => $id));
		$data['tbl_team'] = $this->mymodel->selectDataone('tbl_team', array('id' => $data['tbl_event_register']['team_id']));
		$data['file_team'] = $this->mymodel->selectDataone('file', array('table_id' => $data['tbl_team']['id'], 'table' => 'tbl_team'));
		$data['tbl_event'] = $this->mymodel->selectDataone('tbl_event', array('id' => $data['tbl_event_register']['event_id']));
		$data['file_event'] = $this->mymodel->selectDataone('file', array('table_id' => $data['tbl_event']['id'], 'table' => 'tbl_event'));

		$data['tbl_manager'] = $this->mymodel->selectDataone('tbl_manager', array('team_id' => $data['tbl_team']['id']));
		$data['file_manager'] = $this->mymodel->selectDataone('file', array('table_id' => $data['tbl_manager']['id'], 'table' => 'tbl_manager'));
		$data['tbl_event_register_raider'] = $this->mymodel->selectWhere('tbl_event_register_raider', array('event_register_id' => $id));
		$this->template->load('template/template','eventregister/view', $data);
	}

	public function approve($id){

		$data = array(
			'approve' => 'APPROVE',
			'updated_at' => date('Y-m-d H:i:s')
		);
		$this->mymodel->updateData('tbl_event_register', $data , array('id'=>$id));

		$this->alert->alertapprove();
	}


	public function reject($id){

		$data = array(
			'approve' => 'REJECT',
			'updated_at' => date('Y-m-d H:i:s')
		);
		$this->mymodel->updateData('tbl_event_register', $data , array('id'=>$id));

		$this->alert->alertreject();
	}

	public function addnote($id){
		$data = array(
			'note' => $_POST['note'],
		);
		$this->mymodel->updateData('tbl_event_register', $data , array('id'=>$id));
		$this->alert->alertnote();
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */