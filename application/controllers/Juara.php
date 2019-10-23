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

        $data['tbl_juara'] = $this->mymodel->selectWhere('tbl_juara', array('id_event' => $id));

        $tbl_juara_detail = $this->mymodel->selectWithQuery("SELECT id_raider, SUM(point) as point FROM tbl_juara_detail WHERE id_event = '" . $id . "' GROUP BY id_raider ORDER BY point DESC LIMIT 1");

        $data['tbl_raider'] = $this->mymodel->selectDataone('tbl_raider', array('id' => $tbl_juara_detail[0]['id_raider']));
        $data['file_raider'] = $this->mymodel->selectDataone('file', array('table_id' => $tbl_juara_detail[0]['id_raider'], 'table' => 'tbl_raider'));

        $data['point'] = $tbl_juara_detail[0]['point'];


        
        $data['raider_terdaftar'] = $this->mymodel->selectWithQuery("SELECT a.raider_id as raider_id FROM tbl_event_register_raider a INNER JOIN tbl_event_register b ON a.event_register_id = b.id WHERE b.approve = 'APPROVE' AND b.event_id = " . $id);
        $this->template->load('template/template', 'juara/view', $data);
    }

    public function validate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('dtd[point][0]', '<strong>Point Raider Juara 1 </strong>Mohon Disini', 'required');
        $this->form_validation->set_rules('dtd[point][1]', '<strong>Point Raider Juara 2 </strong>Mohon Disini', 'required');
        $this->form_validation->set_rules('dtd[point][2]', '<strong>Point Raider Juara 3 </strong>Mohon Disini', 'required');
        $this->form_validation->set_message('required', '%s');
    }

    public function addWinner_1($id)
    {
        $dtd['id_juara'] = $id;
        $dtd['id_event'] = $_POST['dtd']['idEvent'];
        $dtd['id_raider'] = $_POST['dtd']['idRaider'];
        $dtd['juara'] = 1;
        $dtd['point'] = $_POST['dtd']['point'];
        $dtd['status'] = 'ENABLE';
        $dtd['created_at'] = date("Y-m-d H:i:s");

        $this->db->insert('tbl_juara_detail', $dtd);

		header('Location:'.base_url('juara/view/'.$_POST['dtd']['idEvent']));
    }

    public function updateWinner_1($id)
    {
        $dtd['id_raider'] = $_POST['dtd']['idRaider'];
        $dtd['point'] = $_POST['dtd']['point'];
        $dtd['updated_at'] = date("Y-m-d H:i:s");

        $this->mymodel->updateData('tbl_juara_detail', $dtd, array('id' => $id));
		header('Location:'.base_url('juara/view/'.$_POST['dtd']['idEvent']));
    }

    public function addWinner_2($id)
    {
        $dtd['id_juara'] = $id;
        $dtd['id_event'] = $_POST['dtd']['idEvent'];
        $dtd['id_raider'] = $_POST['dtd']['idRaider'];
        $dtd['juara'] = 2;
        $dtd['point'] = $_POST['dtd']['point'];
        $dtd['status'] = 'ENABLE';
        $dtd['created_at'] = date("Y-m-d H:i:s");

        $this->db->insert('tbl_juara_detail', $dtd);

		header('Location:'.base_url('juara/view/'.$_POST['dtd']['idEvent']));
    }

    public function updateWinner_2($id)
    {
        $dtd['id_raider'] = $_POST['dtd']['idRaider'];
        $dtd['point'] = $_POST['dtd']['point'];
        $dtd['updated_at'] = date("Y-m-d H:i:s");

        $this->mymodel->updateData('tbl_juara_detail', $dtd, array('id' => $id));
		header('Location:'.base_url('juara/view/'.$_POST['dtd']['idEvent']));
    }

    public function addWinner_3($id)
    {
        $dtd['id_juara'] = $id;
        $dtd['id_event'] = $_POST['dtd']['idEvent'];
        $dtd['id_raider'] = $_POST['dtd']['idRaider'];
        $dtd['juara'] = 3;
        $dtd['point'] = $_POST['dtd']['point'];
        $dtd['status'] = 'ENABLE';
        $dtd['created_at'] = date("Y-m-d H:i:s");

        $this->db->insert('tbl_juara_detail', $dtd);

		header('Location:'.base_url('juara/view/'.$_POST['dtd']['idEvent']));
    }

    public function updateWinner_3($id)
    {
        $dtd['id_raider'] = $_POST['dtd']['idRaider'];
        $dtd['point'] = $_POST['dtd']['point'];
        $dtd['updated_at'] = date("Y-m-d H:i:s");

        $this->mymodel->updateData('tbl_juara_detail', $dtd, array('id' => $id));
		header('Location:'.base_url('juara/view/'.$_POST['dtd']['idEvent']));
    }

    public function update()
    {
        $array = count($_POST['dtd']);
        for ($i = 0; $i <= $array; $i++) {
            $dtd['id_raider'] = $_POST['dtd']['idRaider'][$i];
            $dtd['point'] = $_POST['dtd']['point'][$i];
            $dtd['updated_at'] = date("Y-m-d H:i:s");
            $this->mymodel->updateData('tbl_juara_detail', $dtd, array('id' => $_POST['dtd']['id_juara'][$i]));
        }
        $this->alert->alertsuccess('Success Update Data');
    }

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
