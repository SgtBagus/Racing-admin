<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Merchandise extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Merchandise";
		$data['tbl_merchandise'] = $this->mymodel->selectData('tbl_merchandise');
		$this->template->load('template/template','merchandise/index', $data);
	}

	public function create(){
		$data['page_name'] = "Merchandise";
		$this->template->load('template/template','merchandise/create', $data);
	}

	public function validate(){

		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[title]', '<strong>Judul merchandise / Informasi</strong> Tidak Boleh Kosong', 'required');
		$supported_file = array(
			'jpg', 'jpeg', 'png' 
		);

		$src_file_name = $_FILES['file']['name'];

		if($src_file_name){
			$ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION));

			if (!in_array($ext, $supported_file)) {
				$this->form_validation->set_rules('dt[gambar]', '<strong>Gambar Proyek</strong> Harus berformat PNG, JPG, JPEG', 'required');
			}
		}
		
		$image_detail_row = count($_FILES["file_many"]['name']);
		if($image_detail_row > 3){
			$this->form_validation->set_rules('file[image_detail]', '<strong>Detail Gambar </strong> Maksimal Berjumlah 3 File', 'required');
		}

		if($_FILES["file_many"]["name"][0] != null){
			for ($i=0; $i < $image_detail_row; $i++) {
				$src_file_name_detail = $_FILES["file_many"]["name"][$i];
				if($src_file_name_detail){
					$ext_detail = strtolower(pathinfo($src_file_name_detail, PATHINFO_EXTENSION));
					if (!in_array($ext_detail, $supported_file)) {
						$this->form_validation->set_rules('file[image_detail]', '<strong>Detail Gambar </strong> Harus berformat PNG, JPG, JPEG semuanya', 'required');
					}
				}
			}
		}

		$this->form_validation->set_message('required', '%s');
	}

	public function store(){
		$this->validate();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());
		}else{
			$dt = $_POST['dt'];
			$dt['harga'] = str_replace( ',', '', $dt['harga'] );
			$dt['status'] = "ENABLE";
			$dt['created_at'] = date('Y-m-d H:i:s');

			$str = $this->db->insert('tbl_merchandise', $dt);

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])){
				$dir  = "webfiles/merchandise/";
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
						'table'=> 'tbl_merchandise',
						'table_id'=> $last_id,
						'status'=>'ENABLE',
						'url' => base_url() . $dir . $file['file_name'],
						'created_at'=>date('Y-m-d H:i:s')
					);
					$str = $this->db->insert('file', $data);
				}
			}else{
				$data = array(
					'name' => 'merchandise_default.jpg',
					'mime' => 'image/jpg',
					'dir' => 'webfiles/merchandise/merchandise_default.jpg',
					'table' => 'tbl_merchandise',
					'table_id' => $last_id,
					'url' => base_url().'webfiles/merchandise/merchandise_default.jpg',
					'status' => 'ENABLE',
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->mymodel->insertData('file', $data);
			}
			

			if (!empty($_FILES['file_many']['name'])){
				$countfiles = count($_FILES['file_many']['name']);
				for($i=0;$i<$countfiles;$i++){
					if(!empty($_FILES['file_many']['name'][$i])){
						$_FILES['file']['name'] = $_FILES['file_many']['name'][$i];
						$_FILES['file']['type'] = $_FILES['file_many']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['file_many']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['file_many']['error'][$i];
						$_FILES['file']['size'] = $_FILES['file_many']['size'][$i];

						$dir  = "webfiles/merchandise/";
						$config['upload_path']          = $dir;
						$config['allowed_types']        = '*';
						$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);

						$this->load->library('upload',$config);

						if (!$this->upload->do_upload('file')){
							$error = $this->upload->display_errors();
							$this->alert->alertdanger($error);
						}else{
							$file = $this->upload->data();
							$data = array(
								'id' => '',
								'name'=> $file['file_name'],
								'mime'=> $file['file_type'],
								'dir'=> $dir.$file['file_name'],
								'table'=> 'tbl_merchandise_detail',
								'table_id'=> $last_id,
								'url' => base_url() . $dir . $file['file_name'],
								'status'=>'ENABLE',
								'created_at'=>date('Y-m-d H:i:s')
							);
							$str = $this->db->insert('file', $data);
						}
					}
				}
			}
			$this->alert->alertsuccess('Success Send Data');
		}
	}

	public function edit($id){
		$data['tbl_merchandise'] = $this->mymodel->selectDataone('tbl_merchandise',array('id'=>$id));
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tbl_merchandise'));
		$data['page_name'] = "Merchandise";

		if($data['tbl_merchandise']){
			$this->template->load('template/template','merchandise/edit',$data);
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
			$dt['harga'] = str_replace( ',', '', $dt['harga'] );
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$this->mymodel->updateData('tbl_merchandise', $dt, array('id' => $id));

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])) {
				$dir  = "webfiles/merchandise/";
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
						'table' => 'tbl_merchandise',
						'table_id' =>  $id,
						'url' => base_url() . $dir . $file['file_name'],
						'status' => 'ENABLE',
						'created_at' => date('Y-m-d H:i:s')
					);
					$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_merchandise'));
					if ($file['name'] != "merchandise_default.jpg") {
						@unlink($file['dir']);
					}
					$this->mymodel->updateData('file', $data, array('table_id' =>  $id, 'table' => 'tbl_merchandise'));
				}
			}
			$this->alert->alertsuccess('Success Send Data');
		}
	}

	public function delete()
	{
		$id = $_POST['id'];
		$file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_merchandise'));
		if($file_dir['name'] != 'merchandise_default.jpg'){
			@unlink($file_dir['dir']);
		}
		@unlink($file_dir['dir']);

		$this->mymodel->deleteData('file',  array('id' => $file_dir['id']));
		$this->mymodel->deleteData('tbl_merchandise',  array('id' => $id));
		header('Location:'.base_url('merchandise'));
	}



	public function status($id,$status){
		$this->mymodel->updateData('tbl_merchandise',array('status'=>$status),array('id'=>$id));
		header('Location: '.base_url('merchandise'));
	}

	public function publicStatus($id,$status){
		$this->mymodel->updateData('tbl_merchandise',array('public'=>$status),array('id'=>$id));
		header('Location: '.base_url('merchandise'));
	}
	
	public function editImage($id){
		$data['page_name'] = "Merchandise";
		$data['tbl_merchandise'] = $this->mymodel->selectDataone('tbl_merchandise',array('id'=>$id));
		$data['file_detail'] = $this->mymodel->selectWhere('file',array('table_id'=>$id,'table'=>'tbl_merchandise_detail'));

		if($data['tbl_merchandise']){
			$this->template->load('template/template','merchandise/editImage',$data);
		}else{
			$this->load->view('errors/html/error_404');
			return false;
		}
	}
	
	public function delete_image($id){
		$file_dir = $this->mymodel->selectDataone('file', array('id' => $id));
		$tbl_merchandise = $this->mymodel->selectDataone('tbl_merchandise', array('id' => $file_dir['table_id']));
		@unlink($file_dir['dir']);

		$this->mymodel->deleteData('file',  array('id'=>$id));
		header('Location: '.base_url('merchandise/editImage/'.$tbl_merchandise['id']));
	}
	
	public function add_image($id){
		$tbl_merchandise = $this->mymodel->selectDataone('tbl_merchandise', array('id' => $id));
		$tbl_merchandise = $this->mymodel->selectWithQuery("SELECT count(id) as count from file WHERE table_id = '$id' AND file.table = 'tbl_merchandise_detail'");
		if($tbl_merchandise[0]['count'] < 3){
			if (!empty($_FILES['file']['name'])){
				$dir  = "webfiles/merchandise/";
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
						'id' => '',
						'name'=> $file['file_name'],
						'mime'=> $file['file_type'],
						'dir'=> $dir.$file['file_name'],
						'table'=> 'tbl_merchandise_detail',
						'table_id'=> $id,
						'url' => base_url() . $dir . $file['file_name'],
						'status'=>'ENABLE',
						'created_at'=>date('Y-m-d H:i:s')
					);
					$this->db->insert('file', $data);
					$this->alert->alertsuccess('Success Update Data');
				}
			}
		}else{
			$this->alert->alertdanger('<strong>Detail Gambar</strong> Tidak bisa lebih dari 3 Gambar');
			return false;
		}
	}

	public function editOneImage($id){
		$data['file_detail'] = $this->mymodel->selectDataone('file',array('id'=>$id,'table'=>'tbl_merchandise_detail'));
		$data['tbl_merchandise'] = $this->mymodel->selectDataone('tbl_merchandise', array('id'=>$data['file_detail']['table_id']));
		$data['page_name'] = "Project";

		if($data['file_detail']){
			$this->template->load('template/template','merchandise/editOneImage',$data);
		}else{
			$this->load->view('errors/html/error_404');
			return false;
		}
	}
	
	public function edit_images($id){
		$file_dir = $this->mymodel->selectDataone('file', array('id' => $id));
		$tbl_merchandise = $this->mymodel->selectDataone('tbl_merchandise', array('id' => $file_dir['table_id']));
		if (!empty($_FILES['file']['name'])){
			$dir  = "webfiles/merchandise/";
			$config['upload_path']          = $dir;
			$config['allowed_types']        = '*';
			$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('file')){
				$error = $this->upload->display_errors();
				$this->alert->alertdanger($error);
			}else{
				$file = $this->upload->data();

				$data = array(
					'name'=> $file['file_name'],
					'mime'=> $file['file_type'],
					'dir'=> $dir.$file['file_name'],
					'table'=> 'tbl_merchandise_detail',
					'table_id'=> $tbl_merchandise['id'],
					'url' => base_url() . $dir . $file['file_name'],
					'updated_at'=>date('Y-m-d H:i:s')
				);

				@unlink($file_dir['dir']);

				$this->mymodel->updateData('file', $data , array('id'=>$id));

				$this->alert->alertsuccess('Success Update Data');
			}
		}
	}
	
	public function delete_Allimage($id){
		$merchandise = $this->mymodel->selectDataone('tbl_merchandise',  array('id'=>$id));
		$file_dir = $this->mymodel->selectWhere('file', array('table_id' => $id, 'table' => 'tbl_merchandise_detail'));
		foreach($file_dir as $dir){
			unlink($dir['dir']);
		}

		$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'tbl_merchandise_detail'));
		header('Location: '.base_url('merchandise/editImage/'.$merchandise['id']));
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */