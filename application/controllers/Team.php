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
        $data['tbl_team'] = $this->mymodel->selectDataOne('tbl_team', array('id' => $id));
        $data['file_team'] = $this->mymodel->selectDataOne('file', array('table_id' => $id, 'table' => 'tbl_team'));

        $data['tbl_raider'] = $this->mymodel->selectWhere('tbl_raider', array('team_id' => $id));
        $this->template->load('template/template', 'team/view', $data);
    }

	public function status($id, $status){
		$this->mymodel->updateData('tbl_team',array('status'=>$status),array('id'=>$id));
		header('Location: '.base_url('team'));
    }
    
	public function verificacion($id, $status){
		$this->mymodel->updateData('tbl_team',array('verificacion'=>$status),array('id'=>$id));
		header('Location: '.base_url('team'));
	}

	public function raiderstatus($id, $status, $view){
		$this->mymodel->updateData('tbl_raider' ,array('status'=>$status),array('id'=>$id));
		header('Location: '.base_url('team/view/'.$view));
    }
    
	public function raiderverificacion($id, $status, $view){
		$this->mymodel->updateData('tbl_raider', array('verificacion'=>$status),array('id'=>$id));
		header('Location: '.base_url('team/view/'.$view));
	}
}