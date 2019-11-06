<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rider extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Rider";
		$data['tbl_raider'] = $this->mymodel->selectWithQuery('SELECT * FROM tbl_raider ORDER BY id DESC'); 
		$this->template->load('template/template', 'raider/index', $data);
	}

	public function view($id)
	{
		$data['page_name'] = "Rider";
		$data['Raider'] = $this->mymodel->selectDataOne('tbl_raider', array('id' => $id));
		$this->template->load('template/template', 'raider/view', $data);
	}

	public function status($id, $status)
	{
		$this->mymodel->updateData('tbl_raider', array('status' => $status), array('id' => $id));
		header('Location: ' . base_url('rider'));
	}

	public function verificacion($id, $status)
	{
		$this->mymodel->updateData('tbl_raider', array('verificacion' => $status), array('id' => $id));
		header('Location: ' . base_url('rider'));
	}


	public function create()
	{
		$data['page_name'] = "Rider";
		$this->template->load('template/template', 'raider/create', $data);
	}

	public function validateRider()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[name]', '<strong>Nama</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[nostart]', '<strong>Nomor Start</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[namajersey]', '<strong>Nama di Jersey</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_message('required', '%s');
	}

	public function store()
	{
		$this->validateRider();
		if ($this->form_validation->run() == FALSE) {
			$this->alert->alertdanger(validation_errors());
		} else {
			if ($_POST['dt']['email']) {
				$email_query = $this->mymodel->selectDataone('tbl_raider', array('email' => $_POST['dt']['email']));
				if ($email_query != null) {
					$this->alert->alertdanger('<strong>Email</strong> tersebut sudah Terdaftar');
					return false;
				} else  if ($_POST['password'] != $_POST['confirmpassword']) {
					$this->alert->alertdanger('<strong>Password</strong> & <strong> Konfirmasi Password </strong> tidak sama !');
					return false;
				}
			}

			$dt = $_POST['dt'];
			$dt['eventikut'] = 0;
			$dt['tgllahir'] = date('Y-m-d', strtotime($_POST['dt']['tgllahir']));
			$dt['password'] = md5($_POST['password']);
			$dt['verificacion'] = 'DISABLE';
			$dt['status'] = 'ENABLE';
			$dt['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('tbl_raider', $dt);

			$file['name'] = 'raider_default.png';
			$file['mime'] = 'image/png';
			$file['dir'] = 'webfiles/raider/raider_default.png';
			$file['table'] = 'tbl_raider';
			$file['table_id'] = $this->db->insert_id();
			$file['url'] = 'https://dev.karyastudio.com/nso_mobile/' . $file['dir'];
			$file['status'] = 'ENABLE';
			$file['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('file', $file);

			$this->alert->alertsuccess('Success Send Data');
		}
	}

	public function edit($id)
	{
		$data['tbl_raider'] = $this->mymodel->selectDataone('tbl_raider', array('id' => $id));
		$data['page_name'] = "Rider";
		if ($data['tbl_raider']) {
			$this->template->load('template/template', 'raider/edit', $data);
		} else {
			$this->load->view('errors/html/error_404');
			return false;
		}
	}

	public function update()
	{
		$id = $_POST['dt']['id'];
		$dt = $_POST['dt'];
		$dt['tgllahir'] = date('Y-m-d H:i:s', strtotime($_POST['dt']['tgllahir']));
		$dt['password'] = md5($_POST['password']);
		$dt['updated_at'] = date("Y-m-d H:i:s");
		$this->mymodel->updateData('tbl_raider', $dt, array('id' => $id));

		$this->alert->alertsuccess('Success Send Data');
	}
}
