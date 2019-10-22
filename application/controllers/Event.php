<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Event extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Event";
		$data['tbl_event'] = $this->mymodel->selectData('tbl_event');
		$this->template->load('template/template','event/index', $data);
	}


	public function create(){
		$data['page_name'] = "Event";
		$this->template->load('template/template','event/create', $data);
	}


	public function validate(){

		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('dt[title]', '<strong>Judul Proyek</strong> Tidak Boleh Kosong', 'required');
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

		$this->form_validation->set_rules('dt[tgleventStart]', '<strong>Tanggal Even</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[tgleventEnd]', '<strong>Tanggal Even</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[kota]', '<strong>Kota Even</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[alamat]', '<strong>Alamat Even</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[minraider]', '<strong>Minim Raider</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_rules('dt[maxraider]', '<strong>Maximal Raider</strong> Tidak Boleh Kosong', 'required');
		$this->form_validation->set_message('required', '%s');
	}

	public function store(){
		$this->validate();
		if ($this->form_validation->run() == FALSE){
			$this->alert->alertdanger(validation_errors());
		}else{
			$dt = $_POST['dt'];
			if($dt['minraider'] > $dt['maxraider']){
				$this->alert->alertdanger('<strong>Maximal Raider</strong> tidak bisa kurang dari <strong>Minim Raider</strong');
				return false;
			}
			$dt['latitude'] = 0;
			$dt['longitude'] = 0;
			$dt['statusEvent'] = "STARTED";
			$dt['public'] = "ENABLE";
			$dt['status'] = "ENABLE";
			$dt['created_at'] = date('Y-m-d H:i:s');

			$str = $this->db->insert('tbl_event', $dt);
			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])){
				$dir  = "webfiles/event/";
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
						'table'=> 'tbl_event',
						'table_id'=> $last_id,
						'status'=>'ENABLE',
						'url' => base_url() . $dir . $file['file_name'],
						'created_at'=>date('Y-m-d H:i:s')
					);
					$str = $this->db->insert('file', $data);
				}
			}else{
				$data = array(
					'name' => 'event_default.jpg',
					'mime' => 'image/jpg',
					'dir' => 'webfiles/event/event_default.png',
					'table' => 'tbl_event',
					'table_id' => $last_id,
					'url' => base_url().'webfiles/event/event_default.png',
					'status' => 'ENABLE',
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->mymodel->insertData('file', $data);
			}
			$this->alert->alertsuccess('Success Send Data');
		}
	}

	public function edit($id){
		$data['tbl_event'] = $this->mymodel->selectDataone('tbl_event',array('id'=>$id));
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tbl_event'));
		$data['page_name'] = "Event";

		if($data['tbl_event']){
			$this->template->load('template/template','event/edit',$data);
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
			$this->mymodel->updateData('tbl_event', $dt, array('id' => $id));

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])) {
				$dir  = "webfiles/event/";
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
						'table' => 'tbl_event',
						'table_id' =>  $id,
						'url' => base_url() . $dir . $file['file_name'],
						'status' => 'ENABLE',
						'created_at' => date('Y-m-d H:i:s')
					);
					$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_event'));
					if ($file['name'] != "event_default.jpg") {
						@unlink($file['dir']);
					}
					$this->mymodel->updateData('file', $data, array('table_id' =>  $id, 'table' => 'tbl_event'));
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
		header('Location:'.base_url('event'));
	}

	public function status($id,$status){
		$this->mymodel->updateData('tbl_event',array('status'=>$status),array('id'=>$id));
		header('Location: '.base_url('event'));
	}

	public function publicStatus($id,$status){
		$this->mymodel->updateData('tbl_event',array('public'=>$status),array('id'=>$id));
		header('Location: '.base_url('event'));
	}

	public function start(){
		$id = $_POST['id'];
		$dt['live_url'] = $_POST['dt']['live_url'];
		$dt['statusEvent'] = 'BERJALAN';
		$dt['updated_at'] = date("Y-m-d H:i:s");
		$this->mymodel->updateData('tbl_event', $dt, array('id' => $id));
		header('Location:'.base_url('event'));
	}

	public function cancel($id){
		$dt['live_url'] = $_POST['dt']['live_url'];
		$dt['statusEvent'] = 'BATAL';
		$dt['updated_at'] = date("Y-m-d H:i:s");
		$this->mymodel->updateData('tbl_event', $dt, array('id' => $id));
		header('Location:'.base_url('event'));
	}

	public function finish($id){
		$dt['live_url'] = $_POST['dt']['live_url'];
		$dt['statusEvent'] = 'SELESAI';
		$dt['updated_at'] = date("Y-m-d H:i:s");
		$this->mymodel->updateData('tbl_event', $dt, array('id' => $id));
		header('Location:'.base_url('event'));
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */