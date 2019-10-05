<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Eventregister extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Pendaftar Event";
		$data['tbl_event_register'] = $this->mymodel->selectData('tbl_event_register');
		$this->template->load('template/template','eventregister/index', $data);
	}

	public function view($id)
	{
		$data['page_name'] = "Pendaftar Event";
		// $data['tbl_event_register'] = $this->mymodel->selectData('tbl_event_register');
		$data['tbl_event_register'] = $this->mymodel->selectDataone('tbl_event_register', array('id' => $id));
		$data['tbl_team'] = $this->mymodel->selectDataone('tbl_team', array('id' => $data['tbl_event_register']['team_id']));
		$data['file_team'] = $this->mymodel->selectDataone('file', array('table_id' => $data['tbl_team']['id'], 'table' => 'tbl_team'));
		$data['tbl_manager'] = $this->mymodel->selectWhere('tbl_manager', array('team_id' => $data['tbl_team']['id']));
		$data['tbl_event'] = $this->mymodel->selectDataone('tbl_event', array('id' => $data['tbl_event_register']['event_id']));
		$data['file_event'] = $this->mymodel->selectDataone('file', array('table_id' => $data['tbl_event']['id'], 'table' => 'tbl_event'));

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


	public function finish($id){

		$data = array(
			'approve' => 'FINISH',
			'updated_at' => date('Y-m-d H:i:s')
		);

		$register_id = $this->mymodel->selectDataone('tbl_event_register', array('event_id' => $id ));
		$raider_data = $this->mymodel->selectWhere('tbl_event_register_raider', array('event_register_id' => $register_id['id']));

		foreach ($raider_data as $raider) {
			$raiderevent = $this->mymodel->selectDataone('tbl_raider', array('id' => $raider['raider_id']));

			$dataevent = array(
				'eventikut' => $raiderevent['eventikut'] + 1
			);

			$this->mymodel->updateData('tbl_raider', $dataevent , array('id'=>$raider['raider_id']));
		}
		$this->mymodel->updateData('tbl_event_register', $data , array('event_id'=>$id));
	}

	public function cancel($id){
		$data = array(
			'approve' => 'CANCEL',
			'updated_at' => date('Y-m-d H:i:s')
		);
		$this->mymodel->updateData('tbl_event_register', $data , array('event_id'=>$id));
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