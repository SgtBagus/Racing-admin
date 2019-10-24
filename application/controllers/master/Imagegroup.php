
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Imagegroup extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

	}



	public function index()

	{

		$data['page_name'] = "Groub Gambar";

		$this->template->load('template/template','master/imagegroup/all-master_imagegroup',$data);

	}

	public function create() 

	{

		$this->load->view('master/imagegroup/add-master_imagegroup');

	}

	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_rules('dt[value]', '<strong>Value</strong>', 'required');
	}



	public function store()

	{

		$this->validate();

		if ($this->form_validation->run() == FALSE){

			$this->alert->alertdanger(validation_errors());     

		}else{

			$dt = $_POST['dt'];

			$dt['created_at'] = date('Y-m-d H:i:s');

			$dt['status'] = "ENABLE";

			$str = $this->db->insert('master_imagegroup', $dt);

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])){
				$dir  = "webfiles/covergallery/";
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
						'table'=> 'master_gallery',
						'table_id'=> $last_id,
						'status'=>'ENABLE',
						'url' => base_url() . $dir . $file['file_name'],
						'created_at'=>date('Y-m-d H:i:s')
					);
					$str = $this->db->insert('file', $data);
				}
			}else{
				$data = array(
					'name' => 'gallery_default.jpg',
					'mime' => 'image/jpg',
					'dir' => 'webfiles/covergallery/gallery_default.jpg',
					'table' => 'master_gallery',
					'table_id' => $last_id,
					'url' => base_url().'webfiles/covergallery/gallery_default.jpg',
					'status' => 'ENABLE',
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->mymodel->insertData('file', $data);
			}
			$this->alert->alertsuccess('Success Send Data');

		}

	}



	public function json()

	{

		$status = $_GET['status'];

		if($status==''){

			$status = 'ENABLE';

		}

		header('Content-Type: application/json');

		$this->datatables->select('a.id,a.value,a.status,file.url');
		$this->datatables->join("file","file.table_id=a.id",'left');
		$this->datatables->where('a.status',$status);
		$this->datatables->where('file.table', 'master_gallery');

		$this->datatables->from('master_imagegroup a');

		if($status=="ENABLE"){

			$this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button></div>', 'id');



		}else{

			$this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');



		}

		echo $this->datatables->generate();

	}

	public function edit($id)

	{

		$data['imagegroup'] = $this->mymodel->selectDataone('master_imagegroup',array('id'=>$id));
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id, 'table' => 'master_gallery'));
		$data['page_name'] = "Groub Gambar";

		$this->load->view('master/imagegroup/edit-master_imagegroup',$data);

	}





	public function update()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');



		$this->validate();





		if ($this->form_validation->run() == FALSE){

			$this->alert->alertdanger(validation_errors());     

		}else{

			$id = $this->input->post('id', TRUE);		$dt = $_POST['dt'];

			$dt['updated_at'] = date("Y-m-d H:i:s");

			$this->mymodel->updateData('master_imagegroup', $dt , array('id'=>$id));


			if (!empty($_FILES['file']['name'])) {
				$dir  = "webfiles/covergallery/";
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
						'table' => 'master_gallery',
						'table_id' =>  $id,
						'url' => base_url() . $dir . $file['file_name'],
						'status' => 'ENABLE',
						'created_at' => date('Y-m-d H:i:s')
					);
					$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'master_gallery'));
					if ($file['name'] != "gallery_default.jpg") {
						@unlink($file['dir']);
					}
					$this->mymodel->updateData('file', $data, array('table_id' =>  $id, 'table' => 'master_gallery'));
				}
			}

			$this->alert->alertsuccess('Success Update Data');  }

		}



		public function delete()

		{

			$id = $this->input->post('id', TRUE);

			$file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'master_gallery'));

			if($file_dir['name'] != 'gallery_default.jpg'){
				@unlink($file_dir['dir']);
			}
			$this->mymodel->deleteData('file',  array('id' => $file_dir['id']));
			$this->mymodel->deleteData('master_imagegroup',  array('id' => $id));
			header('Location:'.base_url('master/imagegroup'));

			$this->alert->alertdanger('Success Delete Data');     

		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('master_imagegroup',array('status'=>$status),array('id'=>$id));

			redirect(base_url().'master/imagegroup');

		}





	}

	?>