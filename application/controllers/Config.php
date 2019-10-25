<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Config extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Config";
		$data['marquee'] = $this->mymodel->selectDataone('konfig', array('slug' => 'MARQUEE'));
		$this->template->load('template/template','config/index',$data);
	}

	public function update($id)
	{
		$dt = $_POST['dt'];
		$dt['updated_at'] = date("Y-m-d H:i:s");
		$this->mymodel->updateData('konfig', $dt, array('id' => $id));
		$this->alert->alertsuccess('Success Send Data');
	}

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
