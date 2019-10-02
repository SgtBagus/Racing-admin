<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Team extends MY_Controller {

	public function __construct(){
		parent::__construct();
    }
    
	public function index(){
        $data['page_name'] = "Team";
        $data['tbl_team'] = $this->mymodel->selectData('tbl_team');
        $this->template->load('template/template', 'team/index', $data);
    }

	public function view($id){
        $data['page_name'] = "Team";
        $data['Team'] = $this->mymodel->selectDataOne('tbl_team', array('id' => $id));
        $this->template->load('template/template', 'team/view', $data);
    }

	public function status($id,$status){
		$this->mymodel->updateData('tbl_investor',array('status'=>$status),array('id'=>$id));
		header('Location: '.base_url('admin/investor'));
	}
}