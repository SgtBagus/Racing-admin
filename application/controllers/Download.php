<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Download extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
    }
    
	public function downloadPDFEvent($id){
		$file = $this->mymodel->selectDataone('file', array('table'=>'event_rule', 'id'=>$id));
		$eventname = $this->mymodel->selectDataone('tbl_event', array('id'=> $file['table_id']));

		force_download('Peraturan Event - '.$eventname['title'].'/'.$file['name'], file_get_contents($file['dir'],NULL));	
	}
	
	public function downloadPDFPaket($id){
		$file = $this->mymodel->selectDataone('file', array('table'=>'paket_file', 'id'=>$id));
		$paketname = $this->mymodel->selectDataone('tbl_paket', array('id'=> $file['table_id']));

		force_download('Paket Juara - '.$paketname['title'].'/'.$file['name'], file_get_contents($file['dir'],NULL));	
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
