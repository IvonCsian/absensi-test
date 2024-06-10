<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('history_model');
		$this->load->model('historyagen_model');
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

    function vhistory() {
		$param = array();
		$param['judul'] = "History Transaksi";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('history/vhistory');
        $this->load->view('general/footer');
    }

	function vtrackingdetail() {
		$param = array();
		$param['judul'] = "Detail Tracking";

		$data = array();
		$data['no_bukti_order'] = $_GET['no_trans'];

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('tracking/vtrackdetail',$data);
        $this->load->view('general/footer');
    }

	function vhistoryagen() {
		$param = array();
		$param['judul'] = "History Transaksi";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('agen/vhistoryagen');
        $this->load->view('general/footer');
    }

}
