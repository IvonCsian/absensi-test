<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terima extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('terima_model');
		$this->load->model('pesanan_model');
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

    function apporder() {
		$param = array();
		$param['judul'] = "Orderan Masuk";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('agen/app_order');
        $this->load->view('general/footer');
    }

	function approve_order(){
		$username = $this->session->userdata('username');
		$no_bukti_order = $_POST['no_bukti_order'];
		$update = "update t_checkout set flag_order = 2,tgl_app_order=NOW(),kd_agen='$username' where no_bukti_order= '$no_bukti_order'";
		$this->db->query($update);
		echo 1;
	}

	function kirim_order(){
		$username = $this->session->userdata('username');
		$no_bukti_order = $_POST['no_bukti_order'];
		$update = "update t_checkout set flag_kirim = 1,tgl_kirim=NOW() where no_bukti_order= '$no_bukti_order'";
		$this->db->query($update);

		// --- update stok ---
		$qdetail = "select * from t_checkout_dtl where no_bukti_order = '$no_bukti_order'";
		$rdt = $this->db->query($qdetail);
		$i=0;
		$rows = array();
		foreach($rdt->result() as $dt){
			$rows[$i]['kd_barang'] = $dt->kd_barang;
			$rows[$i]['kuantum'] = $dt->kuantum;

			// --- update stok ---
			$param = array();
			$param['username'] = $username;
			$param['kd_barang'] = $dt->kd_barang;
			$param['kuantum'] = $dt->kuantum;
			$param['tanggal'] = date("Y-m-d");
			$param['kd_bukti'] = $no_bukti_order;
			$Mutasikeluar = $this->terima_model->mutasi_barangkeluar($param);
		}
		echo 1;
	}

}
