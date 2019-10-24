<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Eventdokumentasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_name'] = "Dokumentasi";
        $data['tbl_event'] = $this->mymodel->selectData('tbl_event');
        $this->template->load('template/template', 'eventdokumentasi/index', $data);
    }

    public function view($id)
    {
        $data['page_name'] = "Dokumentasi";
        $data['tbl_event'] = $this->mymodel->selectDataone('tbl_event', array('id' => $id));
        $data['file_event'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_event'));

        $this->template->load('template/template', 'eventdokumentasi/view', $data);
    }

    public function create($id)
    {
        $data['tbl_event'] = $this->mymodel->selectDataone('tbl_event', array('id' => $id));
        $this->load->view('eventdokumentasi/addModal', $data);
    }

    public function json()
    {
        $status = $_GET['status'];
        if ($status == '') {
            $status = 'ENABLE';
        }

        $eventid = $_GET['eventid'];
        header('Content-Type: application/json');
        $this->datatables->select('a.id,a.value,a.status,file.url');
        $this->datatables->join("file", "file.table_id=a.id", 'left');
        $this->datatables->where('a.status', $status);
        $this->datatables->where('a.id_event', $eventid);
        $this->datatables->where('file.table', 'master_gallery');
        $this->datatables->from('master_imagegroup a');
        if ($status == "ENABLE") {
            $this->datatables->add_column('view', '<div class="btn-group"><div class="btn-group"><button type="button" class="btn btn-sm btn-info" onclick="view($1)"><i class="fa fa-eye"></i> View</button><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button></div>', 'id');
        } else {
            $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-info" onclick="view($1)"><i class="fa fa-eye"></i> View</button><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');
        }
        echo $this->datatables->generate();
    }

    public function validate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('dt[value]', '<strong>Value</strong>', 'required');
    }

    public function store()
    {
        $this->validate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $dt = $_POST['dt'];
            $dt['id_event'] = $_POST['eventId'];
            $dt['created_at'] = date('Y-m-d H:i:s');
            $dt['status'] = "ENABLE";
            $str = $this->db->insert('master_imagegroup', $dt);
            $last_id = $this->db->insert_id();
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
                        'table_id' => $last_id,
                        'status' => 'ENABLE',
                        'url' => base_url() . $dir . $file['file_name'],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $str = $this->db->insert('file', $data);
                }
            } else {
                $data = array(
                    'name' => 'gallery_default.jpg',
                    'mime' => 'image/jpg',
                    'dir' => 'webfiles/covergallery/gallery_default.jpg',
                    'table' => 'master_gallery',
                    'table_id' => $last_id,
                    'url' => base_url() . 'webfiles/covergallery/gallery_default.jpg',
                    'status' => 'ENABLE',
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->mymodel->insertData('file', $data);
            }
            $this->alert->alertsuccess('Success Send Data');
        }
    }

    public function edit($id)
    {
        $data['page_name'] = "Dokumentasi";
        $data['imagegroup'] = $this->mymodel->selectDataone('master_imagegroup', array('id' => $id));
        $data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'master_gallery'));
        $data['tbl_event'] = $this->mymodel->selectDataone('tbl_event', array('id' => $id));
        $this->load->view('eventdokumentasi/editModal', $data);
    }

    public function update()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->validate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $id = $this->input->post('id', TRUE);
            $dt = $_POST['dt'];
            $dt['updated_at'] = date("Y-m-d H:i:s");
            $this->mymodel->updateData('master_imagegroup', $dt, array('id' => $id));
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
            $this->alert->alertsuccess('Success Update Data');
        }
    }

    public function delete()
    {
        $id = $_POST['id'];
        $eventid = $_POST['eventId'];

        $file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'master_gallery'));
        if ($file_dir['name'] != 'gallery_default.jpg') {
            @unlink($file_dir['dir']);
        }
        $this->mymodel->deleteData('file',  array('id' => $file_dir['id']));
        $this->mymodel->deleteData('master_imagegroup',  array('id' => $id));
        header('Location:' . base_url('eventdokumentasi/view/') . $eventid);
        $this->alert->alertdanger('Success Delete Data');
    }

    public function status($id, $status)
    {
        $eventid = $_GET['eventid'];
        $this->mymodel->updateData('master_imagegroup', array('status' => $status), array('id' => $id));
        redirect(base_url() . 'eventdokumentasi/view/' . $eventid);
    }

    public function imgedit($id, $eventid)
    {
        $data['event_id'] = $eventid;
        $data['master_imagegroup'] = $this->mymodel->selectDataone('master_imagegroup', array('id' => $id));
        $data['page_name'] = "Gallery";
        if ($data['master_imagegroup']) {
            $this->template->load('template/template', 'eventdokumentasi/gallery/edit', $data);
        } else {
            $this->load->view('errors/html/error_404');
            return false;
        }
    }


    public function addOneImage($id)
    {
        $data['master_imagegroup'] = $this->mymodel->selectDataone('master_imagegroup', array('id' => $id));
        $data['page_name'] = "Gallery";
        $this->template->load('template/template', 'eventdokumentasi/gallery/addImage', $data);
    }

    public function editImage($id, $eventid)
    {
        $data['event_id'] = $eventid;
        $data['tbl_gallery'] = $this->mymodel->selectDataone('tbl_gallery', array('id' => $id));
        $data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $data['tbl_gallery']['id'], 'table' => 'tbl_gallery'));
        $data['master_imagegroup'] = $this->mymodel->selectDataone('master_imagegroup', array('id' => $data['tbl_gallery']['imagegroup_id']));
        $data['page_name'] = "Dokumentasi";
        $this->template->load('template/template', 'eventdokumentasi/gallery/editImage', $data);
    }

    public function validateimage()
    {

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $supported_file = array(
            'jpg', 'jpeg', 'png'
        );

        $src_file_name = $_FILES['file']['name'];

        if ($src_file_name) {
            $ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION));

            if (!in_array($ext, $supported_file)) {
                $this->form_validation->set_rules('dt[gambar]', '<strong>Gambar</strong> Harus berformat PNG, JPG, JPEG', 'required');
            }
        } else {
            $this->form_validation->set_rules('dt[gambar]', '<strong>Gambar</strong> Tidak Boleh Kosong', 'required');
        }

        $this->form_validation->set_rules('dt[title]', '<strong>Judul Gambar</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_message('required', '%s');
    }

    public function add_image($id)
    {
        $this->validateimage();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $dt['imagegroup_id'] = $id;
            $dt['title'] = $_POST['dt']['title'];
            $dt['caption'] = $_POST['dt']['caption'];
            $dt['status'] = "ENABLE";
            $dt['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_gallery', $dt);
            $last_id = $this->db->insert_id();
            if (!empty($_FILES['file']['name'])) {
                $dir  = "webfiles/gallery/";
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
                        'id' => '',
                        'name' => $file['file_name'],
                        'mime' => $file['file_type'],
                        'dir' => $dir . $file['file_name'],
                        'table' => 'tbl_gallery',
                        'table_id' => $last_id,
                        'url' => base_url() . $dir . $file['file_name'],
                        'status' => 'ENABLE',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $str = $this->db->insert('file', $data);
                }
                $this->alert->alertsuccess('Success Send Data');
            }
        }
    }

    public function edit_image($id)
    {

        $dt['imagegroup_id'] = $_POST['dt']['imagegroup_id'];
        $dt['updated_at'] = date('Y-m-d H:i:s');
        $this->mymodel->updateData('tbl_gallery', $dt, array('id' => $id));

        $dtd['title'] = $_POST['dt']['title'];
        $dtd['caption'] = $_POST['dt']['caption'];
        $dtd['status'] = "ENABLE";
        $dtd['updated_at'] = date('Y-m-d H:i:s');
        $this->mymodel->updateData('tbl_gallery', $dtd, array('id' => $id));

        if ($_FILES['file']['name']) {
            $this->validateimage();
            if ($this->form_validation->run() == FALSE) {
                $this->alert->alertdanger(validation_errors());
            } else {
                $dir  = "webfiles/gallery/";
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
                        'table' => 'tbl_gallery',
                        'table_id' => $id,
                        'url' => base_url() . $dir . $file['file_name'],
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_gallery'));
                    @unlink($file_dir['dir']);
                    $this->mymodel->updateData('file', $data, array('table_id' => $id, 'table' => 'tbl_gallery'));
                }
            }
        }
        $this->alert->alertsuccess('Success Send Data');
    }

    public function delete_image($id, $idevent)
    {
        $file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_gallery'));
        @unlink($file_dir['dir']);

        $this->mymodel->deleteData('file', array('table_id' => $id, 'table' => 'tbl_gallery'));
        $this->mymodel->deleteData('tbl_gallery', array('id' => $id));
        header('Location: ' . base_url('eventdokumentasi/view/'.$idevent));
    }
    
    public function delete_Allimage($id)
    {

        $tbl_gallery = $this->mymodel->selectWhere('tbl_gallery',  array('imagegroup_id' => $id));
        foreach ($tbl_gallery as $file) {
            $dir = $this->mymodel->selectDataone('file', array('table_id' => $file['id'], 'table' => 'tbl_gallery'));
            unlink($dir['dir']);
            $this->mymodel->deleteData('file',  array('table_id' => $file['id'], 'table' => 'tbl_gallery'));
        }
        $this->mymodel->deleteData('tbl_gallery',  array('imagegroup_id' => $id));
        header('Location: ' . base_url('gallery'));
    }
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
