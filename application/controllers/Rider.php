<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rider extends MY_Controller {

	public function __construct(){
		parent::__construct();
    }
    
	public function index(){
        $data['page_name'] = "Rider";
        $data['tbl_raider'] = $this->mymodel->selectData('tbl_raider');
        $this->template->load('template/template', 'raider/index', $data);
    }

	public function view($id){
        $data['page_name'] = "Rider";
        $data['Raider'] = $this->mymodel->selectDataOne('tbl_raider', array('id' => $id));
        $this->template->load('template/template', 'raider/view', $data);
    }

	public function status($id, $status){
		$this->mymodel->updateData('tbl_raider' ,array('status'=>$status),array('id'=>$id));
		header('Location: '.base_url('rider'));
    }
    
	public function verificacion($id, $status){
		$this->mymodel->updateData('tbl_raider', array('verificacion'=>$status),array('id'=>$id));
		header('Location: '.base_url('rider'));
	}
}