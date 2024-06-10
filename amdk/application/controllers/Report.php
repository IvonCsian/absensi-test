<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('transaksi_model');
		$this->load->model('report_model');
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

    function vreport() {
		$param = array();
		$param['judul'] = "Report Barang Masuk";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('report/vreport');
        $this->load->view('general/footer');
    }

	function vreportdetail() {
		$param = array();
		$param['judul'] = "Detail Report";

		$data = array();
		$data['no_bukti_bi'] = $_GET['no_trans'];

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('report/vreportdetail',$data);
        $this->load->view('general/footer');
    }

	function vreportpo() {
		$param = array();
		$param['judul'] = "Report PO Pabrik";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('report/vreportpo');
        $this->load->view('general/footer');
    }

	function vreportpodetail() {
		$param = array();
		$param['judul'] = "Detail Report";

		$data = array();
		$data['no_bukti_po'] = $_GET['no_trans'];

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('report/vreportpodetail',$data);
        $this->load->view('general/footer');
    }

	function cancel_po(){
		$no_bukti_po = $_POST['no_bukti_po'];
		$update = "delete from t_order where no_bukti_po = '$no_bukti_po'";
		$this->db->query($update);

		$update2 = "delete from t_order_detail where no_bukti_po = '$no_bukti_po'";
		$this->db->query($update2);
		echo 1;
	}

}
