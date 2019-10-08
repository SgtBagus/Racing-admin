<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blogs extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Blog / Informasi";
		$data['tbl_blog'] = $this->mymodel->selectData('tbl_blog');
		$this->template->load('template/template','blogs/index', $data);
	}

	public function create(){
		$data['page_name'] = "Blog / Informasi";
		$this->template->load('template/template','blogs/create', $data);
	}

	public function validate(){

		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[title]', '<strong>Judul Blog / Informasi</strong> Tidak Boleh Kosong', 'required');
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
		$this->form_validation->set_message('required', '%s');
	}

	public function store(){
		$this->validate();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());
		}else{
			$dt = $_POST['dt'];
			$dt['status'] = "ENABLE";
			$dt['created_at'] = date('Y-m-d H:i:s');

			$str = $this->db->insert('tbl_blog', $dt);

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])){
				$dir  = "webfiles/blogs/";
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
						'table'=> 'tbl_blog',
						'table_id'=> $last_id,
						'status'=>'ENABLE',
						'url' => base_url() . $dir . $file['file_name'],
						'created_at'=>date('Y-m-d H:i:s')
					);
					$str = $this->db->insert('file', $data);
				}
			}else{
				$data = array(
					'name' => 'blog_default.jpg',
					'mime' => 'image/jpg',
					'dir' => 'webfiles/blogs/blog_default.jpg',
					'table' => 'tbl_blog',
					'table_id' => $last_id,
					'url' => base_url().'webfiles/blogs/blog_default.jpg',
					'status' => 'ENABLE',
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->mymodel->insertData('file', $data);
			}
			$this->alert->alertsuccess('Success Send Data');
		}
	}

	public function edit($id){
		$data['tbl_blog'] = $this->mymodel->selectDataone('tbl_blog',array('id'=>$id));
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tbl_blog'));
		$data['page_name'] = "Blog / Informasi";

		if($data['tbl_blog']){
			$this->template->load('template/template','blogs/edit',$data);
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
			$dt['updated_at'] = date("Y-m-d H:i:s");
			$this->mymodel->updateData('tbl_blog', $dt, array('id' => $id));

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])) {
				$dir  = "webfiles/blogs/";
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
						'table' => 'tbl_blog',
						'table_id' =>  $id,
						'url' => base_url() . $dir . $file['file_name'],
						'status' => 'ENABLE',
						'created_at' => date('Y-m-d H:i:s')
					);
					$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_blog'));
					if ($file['name'] != "blog_default.jpg") {
						@unlink($file['dir']);
					}
					$this->mymodel->updateData('file', $data, array('table_id' =>  $id, 'table' => 'tbl_blog'));
				}
			}
			$this->alert->alertsuccess('Success Send Data');
		}
	}

	public function delete()
	{
		$id = $_POST['id'];
		$file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_blog'));
		@unlink($file_dir['dir']);

		$this->mymodel->deleteData('file',  array('id' => $file_dir['id']));
		$this->mymodel->deleteData('tbl_blog',  array('id' => $id));
		header('Location:'.base_url('blogs'));
	}



	public function status($id,$status){
		$this->mymodel->updateData('tbl_blog',array('status'=>$status),array('id'=>$id));
		header('Location: '.base_url('blogs'));
	}

	public function publicStatus($id,$status){
		$this->mymodel->updateData('tbl_blog',array('public'=>$status),array('id'=>$id));
		header('Location: '.base_url('blogs'));
	}

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */