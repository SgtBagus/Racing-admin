<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Komentar";

		$data['tbl_comment'] = $this->mymodel->selectWithQuery('SELECT * FROM tbl_comment ORDER BY created_at, updated_at DESC'); 

		if($_GET['imagegroupid']){
			$data['tbl_comment'] = $this->mymodel->selectWithQuery('SELECT * FROM tbl_comment WHERE imagegroup_id = '.$_GET['imagegroupid'].' ORDER BY created_at, updated_at DESC'); 
		}

		$this->template->load('template/template', 'comment/index', $data);
	}	

	public function validate()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[comment]', '<strong>omment</strong>', 'required');
	}

	public function create($id)
	{
		$data['gallery_id'] = $id;
		$this->load->view('comment/add', $data);
	}

	public function store()
	{
		$this->validate();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());     
		}else{
			$dt = $_POST['dt'];
			$dt['id_user'] = $this->session->userdata('id');
			$dt['status'] = "ENABLE";
			$dt['created_at'] = date('Y-m-d H:i:s');
			$str = $this->db->insert('tbl_comment', $dt);

			$this->alert->alertsuccess('Success Send Data');
		}
	}


	public function edit($id)
	{
		$data['tbl_comment'] = $this->mymodel->selectDataone('tbl_comment',array('id'=>$id));
		$data['page_name'] = "Komentar";
		$this->load->view('comment/edit',$data);
	}

	public function update()
	{
		$this->validate();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());     
		}else{
			$id = $_POST['id'];
			$dt = $_POST['dt'];
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$this->mymodel->updateData('tbl_comment', $dt , array('id'=>$id));
			$this->alert->alertsuccess('Success Update Data');  
		}
	}

	public function status($id, $status)
	{
		$this->mymodel->updateData('tbl_comment', array('status' => $status), array('id' => $id));
		header('Location: ' . base_url('comment'));
	}


	public function delete()
	{
		$id = $_POST['id'];

		$this->mymodel->deleteData('tbl_comment',  array('id' => $id));
		header('Location:'.base_url('comment'));
	}
}
