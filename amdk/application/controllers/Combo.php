<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combo extends CI_Controller {
	
	public function __construct() {
		
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
	
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
    function combo_departemen_filter(){
		$kd_departemen = $this->session->userdata('kd_departemen');

        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		if($kd_departemen == "ALL"){
			$sql = "select * from m_departemen where kd_departemen is not null and nm_departemen like '%$q%' ";
		}
		else{
			$sql = "select * from m_departemen where kd_departemen = '$kd_departemen' and nm_departemen like '%$q%' ";
		}
		
		$data = $this->db->query($sql)->result_array();

        //$data = $this->m_combo->get_pelanggan("", $cari, "", 0, 100)->result_array();

        foreach ($data as $key => $value) {
            $value['id']   = $value['kd_departemen'];
            $value['text'] = $value['kd_departemen']."-".$value['nm_departemen'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}
}
