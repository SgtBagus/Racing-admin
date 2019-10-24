<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['page_name'] = "home";
		$data['totalevent'] = $this->mymodel->selectWithQuery("SELECT COUNT(id) as total FROM tbl_event");
		$data['totalregister'] = $this->mymodel->selectWithQuery("SELECT COUNT(id) as totalregister FROM tbl_event_register WHERE approve = 'WAITING' ");
		$data['totalmerchandise'] = $this->mymodel->selectWithQuery("SELECT COUNT(id) as totalmerchandise FROM tbl_merchandise");
		$data['totalteam'] = $this->mymodel->selectWithQuery("SELECT COUNT(id) as totalteam FROM tbl_team");

		
		$data['tbl_event'] = $this->db->limit(5)->order_by('id', 'DESC')->get_where('tbl_event', array('status' => 'ENABLE'))->result_array();
		$data['tbl_wisata'] = $this->db->limit(5)->order_by('id', 'DESC')->get_where('tbl_wisata', array('status' => 'ENABLE'))->result_array();
		$data['tbl_blog'] = $this->db->limit(5)->order_by('id', 'DESC')->get_where('tbl_blog', array('status' => 'ENABLE'))->result_array();
		$data['master_imagegroup'] = $this->db->limit(5)->order_by('id', 'DESC')->get_where('master_imagegroup', array('status' => 'ENABLE'))->result_array();
		$data['tbl_merchandise'] = $this->db->limit(5)->order_by('id', 'DESC')->get_where('tbl_merchandise', array('status' => 'ENABLE'))->result_array();
		$data['team'] = $this->db->limit(6)->order_by('id', 'DESC')->get_where('tbl_team')->result_array();
		$this->template->load('template/template','index',$data);
		
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */