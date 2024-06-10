<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('transaksi_model');
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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

    function vtransaksi() {
		$param = array();
		$param['judul'] = "Transaksi";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('transaksi/vtransaksi');
        $this->load->view('general/footer');
    }

	function vtransaksidetail() {
		$param = array();
		$param['judul'] = "Detail Transaksi";

		$data = array();
		$data['no_bukti_order'] = $_GET['no_trans'];

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('transaksi/vtransdetail',$data);
        $this->load->view('general/footer');
    }

	function terima_order(){
		$no_bukti_order = $_POST['no_bukti_order'];
		$update = "update t_checkout set flag_done = 1,tgl_done=NOW() where no_bukti_order= '$no_bukti_order'";
		$this->db->query($update);
		echo 1;
	}

}
