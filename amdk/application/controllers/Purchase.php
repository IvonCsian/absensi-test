<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('penerimaan_model');
		$this->load->model('purchase_model');
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

    function inputpo() {
		$param = array();
		$param['judul'] = "Order Pabrik";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('purchase/inp_po');
        $this->load->view('general/footer');
    }

	function inputpodtl() {
		$param = array();
		$param['judul'] = "Detail Order Pabrik";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('purchase/po_detail');
        $this->load->view('general/footer');
    }

	function ins_po_header(){
		$username = $this->session->userdata('username');
		$tanggal = date("Y-m-d");
		$kd_barang = $_POST['kd_barang'];
		$hrg_satuan = $_POST['hrg_satuan'];

		// -- cek order status open ---
		$query = "select * from t_order where user_id='$username' and flag_od=0";
		$result = $this->db->query($query)->num_rows();
		if($result > 0){
			// --- jika masih ada insert detail ---
			$rdt = $this->db->query($query)->result();
			$no_bukti_po = $rdt[0]->no_bukti_po;

			// -- cek barang ---
			$querydetail = "select * from t_order_detail where no_bukti_po='$no_bukti_po' and kd_barang='$kd_barang'";
			$result = $this->db->query($querydetail)->num_rows();
			if($result>0){
				$dt = $this->db->query($querydetail)->result();
				$qty = $dt[0]->kuantum;
				$qtyUpdate = $qty + 1;

				// --- update ---
				$update = "update t_order_detail set kuantum='$qtyUpdate' where no_bukti_po='$no_bukti_po' and kd_barang='$kd_barang'";
				$this->db->query($update);

			}
			else{
			$detail = "insert into t_order_detail set no_bukti_po = '$no_bukti_po',kd_barang='$kd_barang',hrg_satuan='$hrg_satuan'";
			$this->db->query($detail);
			}
			echo 1;
		}
		else{
			// jika tidak ada insert header dan detail ---
			$param = array();
			$param['user'] = $username;
			$param['tanggal'] = date("Y-m-d");
			$param['kd'] = 'po';
			
			$kodebukti = $this->purchase_model->get_bukti($param);

			$header = "insert into t_order set no_bukti_po = '$kodebukti', user_id = '$username', tgl_order = '$tanggal', flag_od = 0";
			$this->db->query($header);

			$detail = "insert into t_order_detail set no_bukti_po = '$kodebukti',kd_barang='$kd_barang',hrg_satuan='$hrg_satuan'";
			$this->db->query($detail);
			echo 1;
		}
	}

	function hapus_po_dtl(){
		$id_od = $_POST['id_od'];
		$hapus = "delete from t_order_detail where id_od='$id_od'";
		$this->db->query($hapus);
		echo 1;
	}
	
	function simpan_po_dtl(){
		$username = $this->session->userdata('username');

		$no_bukti = $_POST['no_bukti'];
		$jumlahdata = $_POST['jumlahdata'];

		// --- update flag od ---
		$update = "update t_order set flag_od = 1 where no_bukti_po = '$no_bukti'";
		$this->db->query($update);

		for($i=1;$i<$jumlahdata;$i++){
			$update_dtl = "update t_order_detail set kuantum= ".$_POST['data_j'.$i]." where id_od='".$_POST['data_k'.$i]."'";
			$this->db->query($update_dtl);
		}
		echo 1;
	}
}
