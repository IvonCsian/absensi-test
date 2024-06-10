<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('order_model');
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

    function orderbarang() {
		$param = array();
		$param['judul'] = "Order Pembelian";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('order/inp_order');
        $this->load->view('general/footer');
    }

	function checkout() {
		$param = array();
		$param['judul'] = "Checkout Pembelian";

		$dataProfile = $this->order_model->ajaxdtprofile($param);
		$data = array();
		
		$data['nama'] = $dataProfile[0]->nm_pelanggan;
		$data['alamat'] = $dataProfile[0]->alamat;
		$data['telp'] = $dataProfile[0]->telp;
		$data['koordinat'] = $dataProfile[0]->koordinat;

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('order/checkout_detail',$data);
        $this->load->view('general/footer');
    }

	function ins_order_header(){
		$username = $this->session->userdata('username');
		$tanggal = date("Y-m-d");
		$kd_barang = $_POST['kd_barang'];

		// -- cek order status open ---
		$query = "select * from t_checkout where user_id='$username' and flag_order=0";
		$result = $this->db->query($query)->num_rows();
		if($result > 0){
			// --- jika masih ada insert detail ---
			$rdt = $this->db->query($query)->result();
			$no_bukti_order = $rdt[0]->no_bukti_order;

			// -- cek barang ---
			$querydetail = "select * from t_checkout_dtl where no_bukti_order='$no_bukti_order' and kd_barang='$kd_barang'";
			$result = $this->db->query($querydetail)->num_rows();
			if($result>0){
				$dt = $this->db->query($querydetail)->result();
				$qty = $dt[0]->kuantum;
				$qtyUpdate = $qty + 1;

				// --- update ---
				$update = "update t_checkout_dtl set kuantum='$qtyUpdate' where no_bukti_order='$no_bukti_order' and kd_barang='$kd_barang'";
				$this->db->query($update);

			}
			else{
			$detail = "insert into t_checkout_dtl set no_bukti_order = '$no_bukti_order',kd_barang='$kd_barang'";
			$this->db->query($detail);
			}
			echo 1;
		}
		else{
			// jika tidak ada insert header dan detail ---
			$param = array();
			$param['user'] = $username;
			$param['tanggal'] = date("Y-m-d");
			$param['kd'] = 'order';
			
			$kodebukti = $this->order_model->get_bukti($param);

			$header = "insert into t_checkout set no_bukti_order = '$kodebukti', user_id = '$username', tgl_order = '$tanggal'";
			$this->db->query($header);

			$detail = "insert into t_checkout_dtl set no_bukti_order = '$kodebukti',kd_barang='$kd_barang'";
			$this->db->query($detail);
			echo 1;
		}
	}

	function hapus_order_dtl(){
		$id_order = $_POST['id_order'];
		$hapus = "delete from t_checkout_dtl where id_order='$id_order'";
		$this->db->query($hapus);
		echo 1;
	}

	function simpan_order_dtl(){
		$username = $this->session->userdata('username');

		$no_bukti = $_POST['no_bukti'];
		$nm_penerima = $_POST['nm_penerima'];
		$alamat = $_POST['alamat'];
		$hp = $_POST['hp'];
		$note = $_POST['note'];
		$jumlahdata = $_POST['jumlahdata'];

		// --- update flag od ---
		$update = "update t_checkout set flag_order = 1,nm_penerima='$nm_penerima',note='$note',alamat_penerima='$alamat',hp_penerima='$hp' where no_bukti_order = '$no_bukti'";
		$this->db->query($update);

		for($i=1;$i<$jumlahdata;$i++){
			$update_dtl = "update t_checkout_dtl set hrg_satuan=".($_POST['data_i'.$i]).",kuantum= ".$_POST['data_j'.$i]." where id_order='".$_POST['data_k'.$i]."'";
			$this->db->query($update_dtl);
		}
		echo 1;
	}
}
