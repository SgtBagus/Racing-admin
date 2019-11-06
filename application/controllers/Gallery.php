<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gallery extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Gallery";
		$data['master_imagegroup'] = $this->mymodel->selectWithQuery('SELECT a.*, b.imagegroup_id FROM master_imagegroup a INNER JOIN tbl_gallery b ON a.id = b.imagegroup_id GROUP BY b.imagegroup_id ORDER BY a.id DESC');
		$this->template->load('template/template','gallery/index',$data);
		
	}

	public function create()
	{
		$data['page_name'] = "Gallery";
		$this->template->load('template/template','gallery/create', $data);
	}


	public function addOneImage($id)
	{
		$data['master_imagegroup'] = $this->mymodel->selectDataone('master_imagegroup', array('id'=>$id));
		$data['tbl_gallery'] = $this->mymodel->selectDataone('tbl_gallery', array('imagegroup_id'=>$id));
		$data['page_name'] = "Gallery";
		$this->template->load('template/template','gallery/addImage', $data);
	}

	public function editImage($id){
		$data['tbl_gallery'] = $this->mymodel->selectDataone('tbl_gallery', array('id'=>$id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id'=>$data['tbl_gallery']['id'], 'table' => 'tbl_gallery'));
		$data['master_imagegroup'] = $this->mymodel->selectDataone('master_imagegroup', array('id'=>$data['tbl_gallery']['imagegroup_id']));
		$data['page_name'] = "Gallery";
		$this->template->load('template/template','gallery/editImage', $data);
	}

	public function edit($id){
		$data['master_imagegroup'] = $this->mymodel->selectDataone('master_imagegroup', array('id'=>$id));
		$data['page_name'] = "Gallery";
		if($data['master_imagegroup']){
			$this->template->load('template/template','gallery/edit',$data);
		}else{
			$this->load->view('errors/html/error_404');
			return false;
		}
	}

	public function validate(){

		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[imagegroup_id]', '<strong>Groub Gambar</strong> Harus Dipilih', 'required');
		$image_detail_row = count($_FILES["file_many"]['name']);

		$supported_file = array(
			'jpg', 'jpeg', 'png'
		);

		if($_FILES["file_many"]["name"][0] != null){
			for ($i=0; $i < $image_detail_row; $i++) {
				$src_file_name_detail = $_FILES["file_many"]["name"][$i];
				if($src_file_name_detail){
					$ext_detail = strtolower(pathinfo($src_file_name_detail, PATHINFO_EXTENSION));
					if (!in_array($ext_detail, $supported_file)) {
						$this->form_validation->set_rules('file[image_detail]', '<strong>Gambar </strong> Harus berformat PNG, JPG, JPEG semuanya', 'required');
					}
				}
				// $nomor = $i+1;
				// $this->form_validation->set_rules('dt[title]['.$i.']', '<strong>Judul Gambar ke-'.$nomor.'</strong> Tidak Boleh Kosong', 'required');
			}
		}else{
			$this->form_validation->set_rules('dt[gambar]', '<strong>Gambar*</strong> Tidak Boleh Kosong', 'required');
		}

		$this->form_validation->set_message('required', '%s');
	}

	public function store(){
		$this->validate();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());
		}else{
			if (!empty($_FILES['file_many']['name'])){
				$countfiles = count($_FILES['file_many']['name']);
				for($i=0;$i<$countfiles;$i++){
					$dt['imagegroup_id'] = $_POST['dt']['imagegroup_id'];
					$dt['title'] = $_POST['dt']['title'][$i];
					$dt['caption'] = $_POST['dt']['caption'][$i];
					$dt['status'] = "ENABLE";
					$dt['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tbl_gallery', $dt);
					$last_id = $this->db->insert_id();

					if(!empty($_FILES['file_many']['name'][$i])){
						$_FILES['file']['name'] = $_FILES['file_many']['name'][$i];
						$_FILES['file']['type'] = $_FILES['file_many']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['file_many']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['file_many']['error'][$i];
						$_FILES['file']['size'] = $_FILES['file_many']['size'][$i];

						$dir  = "webfiles/gallery/";
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
								'table'=> 'tbl_gallery',
								'table_id'=> $last_id,
								'url' => base_url() . $dir . $file['file_name'],
								'status'=>'ENABLE',
								'created_at'=>date('Y-m-d H:i:s')
							);
							$str = $this->db->insert('file', $data);
						}
					}
				}
				$this->alert->alertsuccess('Success Send Data');
			}
		}
	}

	public function validateedit(){

		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[imagegroup_id]', '<strong>Groub Gambar</strong> Harus Dipilih', 'required');
		$this->form_validation->set_message('required', '%s');
	}

	public function update($id){
		$this->validateedit();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());
		}else{
			$dt['imagegroup_id'] = $_POST['dt']['imagegroup_id'];
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$this->mymodel->updateData('tbl_gallery', $dt, array('imagegroup_id' => $id));
			$this->alert->alertsuccess('Success Send Data');
		}
	}


	public function validateimage(){

		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$supported_file = array(
			'jpg', 'jpeg', 'png'
		);

		$src_file_name = $_FILES['file']['name'];

		if($src_file_name){
			$ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION));

			if (!in_array($ext, $supported_file)) {
				$this->form_validation->set_rules('dt[gambar]', '<strong>Gambar</strong> Harus berformat PNG, JPG, JPEG', 'required');
			}
		}else{
			$this->form_validation->set_rules('dt[gambar]', '<strong>Gambar</strong> Tidak Boleh Kosong', 'required');
		}

		$this->form_validation->set_rules('dt[title]', '<strong>Judul Gambar</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_message('required', '%s');
	}

	public function add_image($id){
		$this->validateimage();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());
		}else{
			$dt['imagegroup_id'] = $id;
			$dt['title'] = $_POST['dt']['title'];
			$dt['caption'] = $_POST['dt']['caption'];
			$dt['status'] = "ENABLE";
			$dt['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('tbl_gallery', $dt);
			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])){
				$dir  = "webfiles/gallery/";
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
						'table'=> 'tbl_gallery',
						'table_id'=> $last_id,
						'url' => base_url() . $dir . $file['file_name'],
						'status'=>'ENABLE',
						'created_at'=>date('Y-m-d H:i:s')
					);
					$str = $this->db->insert('file', $data);
				}
				$this->alert->alertsuccess('Success Send Data');
			}
		}
	}

	public function edit_image($id){
		$dt['imagegroup_id'] = $_POST['dt']['imagegroup_id'];
		$dt['updated_at'] = date('Y-m-d H:i:s');
		$this->mymodel->updateData('tbl_gallery', $dt , array('id'=>$id));

		if (!empty($_FILES['file']['name'])){
			$this->validateimage();
			if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());
			}else{
				$dtd['title'] = $_POST['dt']['title'];
				$dtd['caption'] = $_POST['dt']['caption'];
				$dtd['status'] = "ENABLE";
				$dtd['updated_at'] = date('Y-m-d H:i:s');
				$this->mymodel->updateData('tbl_gallery', $dtd , array('id'=>$id));

				$dir  = "webfiles/gallery/";
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
						'table'=> 'tbl_gallery',
						'table_id'=> $id,
						'url' => base_url().$dir.$file['file_name'],
						'updated_at'=>date('Y-m-d H:i:s')
					);
					$file_dir = $this->mymodel->selectDataone('file', array('table_id'=>$id, 'table' => 'tbl_gallery'));
					@unlink($file_dir['dir']);
					$this->mymodel->updateData('file', $data , array('table_id'=>$id, 'table' => 'tbl_gallery'));
				}
			}
		}
		$this->alert->alertsuccess('Success Send Data');
	}
	
	public function delete_image($id){
		$file_dir = $this->mymodel->selectDataone('file', array('table_id'=>$id, 'table' => 'tbl_gallery'));
		@unlink($file_dir['dir']);

		$this->mymodel->deleteData('file', array('table_id'=>$id, 'table' => 'tbl_gallery'));
		$this->mymodel->deleteData('tbl_gallery', array('id'=>$id));
		header('Location: '.base_url('gallery'));
	}

	public function delete_Allimage($id){

		$tbl_gallery = $this->mymodel->selectWhere('tbl_gallery',  array('imagegroup_id'=>$id));
		foreach($tbl_gallery as $file){
			$dir = $this->mymodel->selectDataone('file', array('table_id' => $file['id'], 'table' => 'tbl_gallery'));
			unlink($dir['dir']);
			$this->mymodel->deleteData('file',  array('table_id'=>$file['id'], 'table'=>'tbl_gallery'));
		}
		$this->mymodel->deleteData('tbl_gallery',  array('imagegroup_id'=>$id));
		header('Location: '.base_url('gallery'));
	}
	
	public function delete()
	{
	    $id = $_POST['id'];
		$tbl_gallery = $this->mymodel->selectWhere('tbl_gallery',  array('imagegroup_id'=>$id));
		foreach($tbl_gallery as $file){
			$dir = $this->mymodel->selectDataone('file', array('table_id' => $file['id'], 'table' => 'tbl_gallery'));
			unlink($dir['dir']);
			$this->mymodel->deleteData('file',  array('table_id'=>$file['id'], 'table'=>'tbl_gallery'));
		}
		$this->mymodel->deleteData('tbl_gallery',  array('imagegroup_id'=>$id));
		header('Location: '.base_url('gallery'));
	}

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */