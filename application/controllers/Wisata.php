<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wisata extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Wisata";
		$data['tbl_wisata'] = $this->mymodel->selectData('tbl_wisata');
		$this->template->load('template/template','wisata/index', $data);
	}

	public function create(){
		$data['page_name'] = "Wisata";
		$this->template->load('template/template','wisata/create', $data);
	}

	public function validate(){

		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[title]', '<strong>Judul Wisata</strong> Tidak Boleh Kosong', 'required');
		$supported_file = array(
			'jpg', 'jpeg', 'png'
		);

		$src_file_name = $_FILES['file']['name'];

		if($src_file_name){
			$ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION));

			if (!in_array($ext, $supported_file)) {
				$this->form_validation->set_rules('dt[gambar]', '<strong>Gambar Wisata</strong> Harus berformat PNG, JPG, JPEG', 'required');
			}
		}
		$this->form_validation->set_rules('dt[tglwisataStart]', '<strong>Tanggal Mulai Wisata</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[tglwisataEnd]', '<strong>Tanggal Selesai Wisata/strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_message('required', '%s');
	}

	public function store(){
		$this->validate();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());
		}else{
			$dt = $_POST['dt'];
			$dt['status'] = "ENABLE";
			$dt['tglwisataStart'] = date('Y-m-d', strtotime($_POST['dt']['tglwisataStart']));
			$dt['tglwisataEnd'] = date('Y-m-d', strtotime($_POST['dt']['tglwisataEnd']));
			$dt['created_at'] = date('Y-m-d H:i:s');

			$str = $this->db->insert('tbl_wisata', $dt);

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])){
				$dir  = "webfiles/wisata/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('file')){
					$error = $this->upload->display_errors();
					$this->alert->alertdanger($error);
				}else{
					$file = $this->upload->data();
					$data = array(
						'name'=> $file['file_name'],
						'mime'=> $file['file_type'],
						'dir'=> $dir.$file['file_name'],
						'table'=> 'tbl_wisata',
						'table_id'=> $last_id,
						'status'=>'ENABLE',
						'url' => base_url() . $dir . $file['file_name'],
						'created_at'=>date('Y-m-d H:i:s')
					);
					$str = $this->db->insert('file', $data);
				}
			}else{
				$data = array(
					'name' => 'wisata_default.jpg',
					'mime' => 'image/jpg',
					'dir' => 'webfiles/wisata/wisata_default.jpg',
					'table' => 'tbl_wisata',
					'table_id' => $last_id,
					'url' => base_url().'webfiles/wisata/wisata_default.jpg',
					'status' => 'ENABLE',
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->mymodel->insertData('file', $data);
			}
			$this->alert->alertsuccess('Success Send Data');
		}
	}

	public function edit($id){
		$data['tbl_wisata'] = $this->mymodel->selectDataone('tbl_wisata',array('id'=>$id));
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tbl_wisata'));
		$data['page_name'] = "Wisata";

		if($data['tbl_wisata']){
			$this->template->load('template/template','wisata/edit',$data);
		}else{
			$this->load->view('errors/html/error_404');
			return false;
		}
	}


	public function update()
	{
		$this->validate();
		if ($this->form_validation->run() == FALSE) {
			$this->alert->alertdanger(validation_errors());
		} else {
			$id = $_POST['dt']['id'];
			$dt = $_POST['dt'];
			$dt['tglwisataStart'] = date('Y-m-d', strtotime($_POST['dt']['tglwisataStart']));
			$dt['tglwisataEnd'] = date('Y-m-d', strtotime($_POST['dt']['tglwisataEnd']));
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$this->mymodel->updateData('tbl_wisata', $dt, array('id' => $id));

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])) {
				$dir  = "webfiles/wisata/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('file')) {
					$error = $this->upload->display_errors();
					$this->alert->alertdanger($error);
				} else {
					$file = $this->upload->data();
					$data = array(
						'name' => $file['file_name'],
						'mime' => $file['file_type'],
						'dir' => $dir . $file['file_name'],
						'table' => 'tbl_wisata',
						'table_id' =>  $id,
						'url' => base_url() . $dir . $file['file_name'],
						'status' => 'ENABLE',
						'created_at' => date('Y-m-d H:i:s')
					);
					$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_wisata'));
					if ($file['name'] != "wisata_default.jpg") {
						@unlink($file['dir']);
					}
					$this->mymodel->updateData('file', $data, array('table_id' =>  $id, 'table' => 'tbl_wisata'));
				}
			}
			$this->alert->alertsuccess('Success Send Data');
		}
	}

	public function delete()
	{
		$id = $_POST['id'];
		$file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_wisata'));
		if($file_dir['name'] != 'wisata_default.jpg'){
			@unlink($file_dir['dir']);
		}
		$this->mymodel->deleteData('file',  array('id' => $file_dir['id']));
		$this->mymodel->deleteData('tbl_wisata',  array('id' => $id));
		header('Location:'.base_url('wisata'));
	}

	public function status($id,$status){
		$this->mymodel->updateData('tbl_wisata',array('status'=>$status),array('id'=>$id));
		header('Location: '.base_url('wisata'));
	}

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */