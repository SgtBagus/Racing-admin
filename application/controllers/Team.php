<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Team extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Team";
		$data['tbl_team'] = $this->mymodel->selectData('tbl_team');
		$this->template->load('template/template', 'team/index', $data);
	}

	public function create()
	{
		$data['page_name'] = "Team";
		$this->template->load('template/template', 'team/create', $data);
	}

	public function edit($id)
	{
		$data['tbl_team'] = $this->mymodel->selectDataone('tbl_team', array('id' => $id));
		$data['page_name'] = "Team";
		if ($data['tbl_team']) {
			$this->template->load('template/template', 'team/edit', $data);
		} else {
			$this->load->view('errors/html/error_404');
			return false;
		}
	}
	
	public function view($id)
	{
		$data['page_name'] = "Team";
		$data['tbl_team'] = $this->mymodel->selectDataOne('tbl_team', array('id' => $id));
		$data['file_team'] = $this->mymodel->selectDataOne('file', array('table_id' => $id, 'table' => 'tbl_team'));

		$data['tbl_raider'] = $this->mymodel->selectWhere('tbl_raider', array('team_id' => $id));
		$data['tbl_manager'] = $this->mymodel->selectWhere('tbl_manager', array('team_id' => $data['tbl_team']['id']));
		$this->template->load('template/template', 'team/view', $data);
	}

	public function status($id, $status)
	{
		$this->mymodel->updateData('tbl_team', array('status' => $status), array('id' => $id));
		header('Location: ' . base_url('team'));
	}

	public function verificacion($id, $status)
	{
		$this->mymodel->updateData('tbl_team', array('verificacion' => $status), array('id' => $id));
		header('Location: ' . base_url('team'));
	}

	public function raiderstatus($id, $status, $view)
	{
		$this->mymodel->updateData('tbl_raider', array('status' => $status), array('id' => $id));
		header('Location: ' . base_url('team/view/' . $view));
	}

	public function raiderverificacion($id, $status, $view)
	{
		$this->mymodel->updateData('tbl_raider', array('verificacion' => $status), array('id' => $id));
		header('Location: ' . base_url('team/view/' . $view));
	}

	public function validate()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[name]', '<strong>Nama Tim</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[email]', '<strong>Email Tim</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('password', '<strong>Password</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('confirmpassword', '<strong>Konfirmasi Password</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[alamat]', '<strong>Alamat Tim</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[kota]', '<strong>Kota Tim</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[nowa]', '<strong>Nomor Wa</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_message('required', '%s');
	}

	public function store()
	{
		$this->validate();
		if ($this->form_validation->run() == FALSE) {
			$this->alert->alertdanger(validation_errors());
		} else {
			$email_query = $this->mymodel->selectDataone('tbl_team', array('email' => $_POST['dt']['email']));
			if ($email_query != null) {
				$this->alert->alertdanger('<strong>Email</strong> tersebut sudah Terdaftar');
				return false;
			} else if ($_POST['password'] != $_POST['confirmpassword']) {
				$this->alert->alertdanger('<strong>Password</strong> & <strong> Konfirmasi Password </strong> tidak sama !');
				return false;
			} else {
				$dt = $_POST['dt'];
				$dt['password'] = md5($_POST['password']);
				$dt['verificacion'] = "DISABLE";
				$dt['status'] = "ENABLE";
				$dt['created_at'] = date('Y-m-d H:i:s');
				$this->db->insert('tbl_team', $dt);

				$file['name'] = 'team_default.png';
				$file['mime'] = 'image/png';
				$file['dir'] = 'webfiles/team/team_default.png';
				$file['table'] = 'tbl_team';
				$file['table_id'] = $this->db->insert_id();
				$file['url'] = 'http://192.168.100.9:8000/' . $file['dir'];
				$file['status'] = 'ENABLE';
				$file['created_at'] = date('Y-m-d H:i:s');
				$this->db->insert('file', $file);
				$this->alert->alertsuccess('Success Send Data');
			}
		}
	}


	public function update()
	{
		$id = $_POST['dt']['id'];
		$dt = $_POST['dt'];
		$dt['password'] = md5($_POST['password']);
		$dt['updated_at'] = date("Y-m-d H:i:s");
		$this->mymodel->updateData('tbl_team', $dt, array('id' => $id));

		$this->alert->alertsuccess('Success Send Data');
	}
}
