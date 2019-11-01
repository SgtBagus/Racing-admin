<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Juara extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_name'] = "Data Juara";
        $data['tbl_event'] = $this->mymodel->selectData('tbl_event');
        $this->template->load('template/template', 'juara/index', $data);
    }

    public function view($id)
    {
        $data['page_name'] = "Data Juara";
        $data['tbl_event'] = $this->mymodel->selectDataone('tbl_event', array('id' => $id));
        $data['file_event'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_event'));
        $this->template->load('template/template', 'juara/view', $data);
    }

    public function paketcreate($event_id)
    {
        $data['event_id'] = $event_id;
        $this->load->view('juara/add-tbl_paket', $data);
    }

    public function paketvalidate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('dt[title]', '<strong>Title</strong>', 'required');
    }

    public function paketstore()
    {
        $this->paketvalidate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $dt = $_POST['dt'];
            $dt['created_at'] = date('Y-m-d H:i:s');
            $dt['status'] = "ENABLE";
            $this->db->insert('tbl_paket', $dt);
            $last_id = $this->db->insert_id();

            if (!empty($_FILES['rule']['name'])) {
                $dirrule  = "webfiles/juara/";
                $configrule['upload_path']          = $dirrule;
                $configrule['allowed_types']        = '*';
                $configrule['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);

                $this->load->library('upload', $configrule);
                if (!$this->upload->do_upload('rule')) {
                    $error = $this->upload->display_errors();
                    $this->alert->alertdanger($error);
                } else {
                    $rule = $this->upload->data();
                    $datarule = array(
                        'name' => $rule['file_name'],
                        'mime' => $rule['file_type'],
                        'dir' => $dirrule . $rule['file_name'],
                        'table' => 'paket_file',
                        'table_id' => $last_id,
                        'status' => 'ENABLE',
                        'url' => base_url() . $dirrule . $rule['file_name'],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $str = $this->db->insert('file', $datarule);
                }
            }


            $this->alert->alertsuccess('Success Send Data');
        }
    }

    public function paketjson($event_id)
    {
        header('Content-Type: application/json');
        $this->datatables->select('id,id_event,title,status');
        $this->datatables->from('tbl_paket');
        $this->datatables->where('id_event', $event_id);
        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-info" onclick="view($1)"><i class="fa fa-eye"></i> Lihat</button><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');
        echo $this->datatables->generate();
    }

    public function paketedit($id, $event_id)
    {
        $data['tbl_paket'] = $this->mymodel->selectDataone('tbl_paket', array('id' => $id));
        $data['rule'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'paket_file'));

        $data['page_name'] = "tbl_paket";
        $this->load->view('juara/edit-tbl_paket', $data);
    }


    public function paketupdate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->paketvalidate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $id = $this->input->post('id', TRUE);
            $dt = $_POST['dt'];
            $dt['updated_at'] = date("Y-m-d H:i:s");
            $this->mymodel->updateData('tbl_paket', $dt, array('id' => $id));

            if (!empty($_FILES['rule']['name'])) {
                $dirrule  = "webfiles/juara/";
                $confrule['upload_path']          = $dirrule;
                $confrule['allowed_types']        = '*';
                $confrule['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);

                $this->load->library('upload', $confrule);
                if (!$this->upload->do_upload('rule')) {
                    $error = $this->upload->display_errors();
                    $this->alert->alertdanger($error);
                } else {
                    $filerule = $this->upload->data();
                    $datarule = array(
                        'name' => $filerule['file_name'],
                        'mime' => $filerule['file_type'],
                        'dir' => $dirrule . $filerule['file_name'],
                        'table' => 'paket_file',
                        'table_id' =>  $id,
                        'url' => base_url() . $dirrule . $filerule['file_name'],
                        'status' => 'ENABLE',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $filerulecheck = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'paket_file'));

                    if ($filerulecheck['name']) {
                        @unlink($filerulecheck['dir']);
                    }

                    if (!$filerulecheck) {
                        $str = $this->db->insert('file', $datarule);
                    } else {
                        $this->mymodel->updateData('file', $datarule, array('table_id' =>  $id, 'table' => 'paket_file'));
                    }
                }
            }
            $this->alert->alertsuccess('Success Update Data');
        }
    }

    public function paketdelete()
    {
        $id = $this->input->post('id', TRUE);

        $file_rule = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'paket_file'));
        if ($file_rule['name']) {
            @unlink($file_rule['dir']);
        }
        $this->mymodel->deleteData('file',  array('id' => $file_rule['id']));

        $this->mymodel->deleteData('tbl_paket',  array('id' => $id));
        $this->alert->alertdanger('Success Delete Data');
    }

    public function paket($id, $event_id)
    {
        $data['tbl_event'] = $this->mymodel->selectDataone('tbl_event', array('id' => $event_id));
        $data['tbl_paket'] = $this->mymodel->selectDataone('tbl_paket', array('id' => $id));
        $this->template->load('template/template', 'juara/paket/index', $data);
    }

    public function detailpaketjson($id)
    {
        header('Content-Type: application/json');
        $this->datatables->select('a.id,b.name as id_team,c.name as id_raider,a.number,a.keterangan');
        $this->datatables->from('tbl_paket_detail a');
        $this->datatables->join("tbl_team b", "b.id=a.id_team", 'left');
        $this->datatables->join("tbl_raider c", "c.id=a.id_raider", 'left');
        $this->datatables->where('a.id_paket', $id);
        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');
        echo $this->datatables->generate();
    }

    public function detailpaketcreate($paket_id, $event_id)
    {
        $data['paket_id'] = $paket_id;
        $data['event_id'] = $event_id;
        $this->load->view('juara/paket/add-tbl_paket_detail', $data);
    }

    public function paketdetailvalidate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('dt[id_team]', '<strong>Id Team</strong>', 'required');
        $this->form_validation->set_rules('dt[number]', '<strong>Number</strong>', 'required');
    }

    public function paketdetailstore()
    {
        $this->paketdetailvalidate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $dt = $_POST['dt'];
            $dt['created_at'] = date('Y-m-d H:i:s');
            $dt['status'] = "ENABLE";
            $str = $this->db->insert('tbl_paket_detail', $dt);
            $this->alert->alertsuccess('Success Send Data');
        }
    }

    public function detailpaketedit($id, $event_id)
    {
        $data['tbl_paket_detail'] = $this->mymodel->selectDataone('tbl_paket_detail', array('id' => $id));
        $data['event_id'] = $event_id;
        $data['page_name'] = "tbl_paket_detail";
        $this->load->view('juara/paket/edit-tbl_paket_detail', $data);
    }

    public function paketdetailupdate()
    {
        $this->paketdetailvalidate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $id = $this->input->post('id', TRUE);
            $dt = $_POST['dt'];
            $dt['updated_at'] = date("Y-m-d H:i:s");
            $this->mymodel->updateData('tbl_paket_detail', $dt, array('id' => $id));
            $this->alert->alertsuccess('Success Update Data');
        }
    }

    public function pakedetaildelete()
    {
        $id = $this->input->post('id', TRUE);
        $this->mymodel->deleteData('tbl_paket_detail',  array('id' => $id));
        $this->alert->alertdanger('Success Delete Data');
    }
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
