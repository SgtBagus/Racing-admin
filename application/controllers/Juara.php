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

        $this->template->load('template/template', 'juara/view', $data);
    }

    public function addDays($id)
    {
        $data['page_name'] = "Data Juara";
        $data['id'] = $id;

        $data['raider_terdaftar'] = $this->mymodel->selectWithQuery("SELECT a.raider_id as raider_id FROM tbl_event_register_raider a INNER JOIN tbl_event_register b ON a.event_register_id = b.id WHERE b.approve = 'APPROVE' AND b.event_id = " . $id);

        $this->template->load('template/template', 'juara/addDays', $data);
    }

    public function viewDays($id)
    {
        $data['page_name'] = "Data Juara";
        $data['tbl_juara'] = $this->mymodel->selectDataone('tbl_juara', array('id' => $id));
        $data['raider_terdaftar'] = $this->mymodel->selectWithQuery("SELECT a.raider_id as raider_id FROM tbl_event_register_raider a INNER JOIN tbl_event_register b ON a.event_register_id = b.id WHERE b.approve = 'APPROVE' AND b.event_id = " . $data['tbl_juara']['id_event']);
        $data['tbl_juara_detail'] = $this->mymodel->selectWhere('tbl_juara_detail', array('id_juara' => $data['tbl_juara']['id']));

        $this->template->load('template/template', 'juara/viewDays', $data);
    }

    public function validate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('dtd[point][0]', '<strong>Point Raider Juara 1 </strong>Mohon Disini', 'required');
        $this->form_validation->set_rules('dtd[point][1]', '<strong>Point Raider Juara 2 </strong>Mohon Disini', 'required');
        $this->form_validation->set_rules('dtd[point][2]', '<strong>Point Raider Juara 3 </strong>Mohon Disini', 'required');
        $this->form_validation->set_message('required', '%s');
    }

    public function store()
    {
        $id = $_POST['id_event'];
        $this->validate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $tbl_juara = $this->mymodel->selectWithQuery("SELECT MAX(days) as day FROM tbl_juara WHERE id_event = '" . $id . "'");

            $days = 1;
            if ($tbl_juara[0]['day']) {
                $days = $tbl_juara[0]['day'] + 1;
            }

            $dt['id_event'] = $id;
            $dt['days'] = $days;
            $dt['status'] = 'ENABLE';
            $dt['created_at'] = date("Y-m-d H:i:s");
            $dt['updated_at'] = date("Y-m-d H:i:s");
            $this->db->insert('tbl_juara', $dt);
            $last_id = $this->db->insert_id();

            $array = count($_POST['dtd']);

            for ($i = 0; $i <= $array; $i++) {
                $dtd['id_juara'] = $last_id;
                $dtd['id_event'] = $id;
                $dtd['id_raider'] = $_POST['dtd']['idRaider'][$i];
                $dtd['point'] = $_POST['dtd']['point'][$i];
                $dtd['status'] = 'ENABLE';
                $dtd['created_at'] = date("Y-m-d H:i:s");
                $dtd['updated_at'] = date("Y-m-d H:i:s");
                $this->db->insert('tbl_juara_detail', $dtd);
            }
            $this->alert->alertsuccess('Success Send Data');
        }
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

    
	public function delete($id, $event_id)
	{
        var_dump($id);
        var_dump($event_id);
		$this->mymodel->deleteData('tbl_juara',  array('id' => $id));
		$this->mymodel->deleteData('tbl_juara_detail',  array('id_juara' => $id));
		header('Location:'.base_url('juara/view/'.$event_id));
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
