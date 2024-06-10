<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangmasuk extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('bi_model');
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

    function barangmasuk() {
		$param = array();
		$param['judul'] = "Penerimaan Barang Masuk";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('barangmasuk/input_bi');
        $this->load->view('general/footer');
    }

	function approve_bi(){
		$username = $this->session->userdata('username');
		$no_bukti_po = $_POST['no_bukti_po'];
		$tanggal = date("Y-m-d");

		// --- update order ---
		$update = "update t_order set flag_od = 2,flag_bi=1 where no_bukti_po= '$no_bukti_po'";
		$this->db->query($update);

		// --- insert bi ---
		$query = "select * from t_bi where user_id='$username' and no_ref_po='$no_bukti_po' and flag_bi=0";
		$result = $this->db->query($query)->num_rows();
		if($result == 0){
			$param = array();
			$param['user'] = $username;
			$param['tanggal'] = date("Y-m-d");
			$param['kd'] = 'bi';
			
			$kodebukti = $this->bi_model->get_bukti($param);

			$header = "insert into t_bi set no_bukti_bi = '$kodebukti',no_ref_po='$no_bukti_po', user_id = '$username', tgl_bi = '$tanggal', flag_bi = 1";
			$this->db->query($header);

			// --- detail bi ---
			$qdetail = "select * from t_order_detail where no_bukti_po = '$no_bukti_po'";
			$rdt = $this->db->query($qdetail);
			$i=0;
			$rows = array();
			foreach($rdt->result() as $dt){
				$rows[$i]['kd_barang'] = $dt->kd_barang;
				$rows[$i]['kuantum'] = $dt->kuantum;
				$rows[$i]['hrg_satuan'] = $dt->hrg_satuan;

				$detail = "insert into t_bi_detail set no_bukti_bi = '$kodebukti',kd_barang='$dt->kd_barang',hrg_satuan='$dt->hrg_satuan',kuantum='$dt->kuantum'";
				$this->db->query($detail);

				// --- insert m_harga_beli ---
				$param = array();
				$param['username'] = $username;
				$param['kd_barang'] = $dt->kd_barang;
				$param['hrg_satuan'] = $dt->hrg_satuan;

				$Hargabeli = $this->bi_model->ins_harga_beli($param);
				$Hargajual = $this->bi_model->ins_harga_jual($param);

				// --- insert mutasi kartubarang---
				$param = array();
				$param['username'] = $username;
				$param['kd_barang'] = $dt->kd_barang;
				$param['hrg_satuan'] = $dt->hrg_satuan;
				$param['kuantum'] = $dt->kuantum;
				$param['tanggal'] = $tanggal;
				$param['kd_bukti'] = $kodebukti;
				$Mutasimasuk = $this->bi_model->mutasi_barangmasuk($param);

			}
		}

		echo 1;
	}

}
