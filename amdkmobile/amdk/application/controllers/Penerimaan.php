<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('penerimaan_model');
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

    function inputbi() {
		$param = array();
		$param['judul'] = "Penerimaan Barang Masuk";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('agen/inp_bi');
        $this->load->view('general/footer');
    }

	function inputbidtl() {
		$param = array();
		$param['judul'] = "Detail Penerimaan";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('agen/bi_detail');
        $this->load->view('general/footer');
    }

	function ins_bi_header(){
		$username = $this->session->userdata('username');
		$tanggal = date("Y-m-d");
		$kd_barang = $_POST['kd_barang'];

		// -- cek order status open ---
		$query = "select * from t_bi where user_id='$username' and flag_bi=0";
		$result = $this->db->query($query)->num_rows();
		if($result > 0){
			// --- jika masih ada insert detail ---
			$rdt = $this->db->query($query)->result();
			$no_bukti_bi = $rdt[0]->no_bukti_bi;

			// -- cek barang ---
			$querydetail = "select * from t_bi_detail where no_bukti_bi='$no_bukti_bi' and kd_barang='$kd_barang'";
			$result = $this->db->query($querydetail)->num_rows();
			if($result>0){
				$dt = $this->db->query($querydetail)->result();
				$qty = $dt[0]->kuantum;
				$qtyUpdate = $qty + 1;

				// --- update ---
				$update = "update t_bi_detail set kuantum='$qtyUpdate' where no_bukti_bi='$no_bukti_bi' and kd_barang='$kd_barang'";
				$this->db->query($update);

			}
			else{
			$detail = "insert into t_bi_detail set no_bukti_bi = '$no_bukti_bi',kd_barang='$kd_barang'";
			$this->db->query($detail);
			}
			echo 1;
		}
		else{
			// jika tidak ada insert header dan detail ---
			$param = array();
			$param['user'] = $username;
			$param['tanggal'] = date("Y-m-d");
			$param['kd'] = 'bi';
			
			$kodebukti = $this->penerimaan_model->get_bukti($param);

			$header = "insert into t_bi set no_bukti_bi = '$kodebukti', user_id = '$username', tgl_bi = '$tanggal', flag_bi = 0";
			$this->db->query($header);

			$detail = "insert into t_bi_detail set no_bukti_bi = '$kodebukti',kd_barang='$kd_barang'";
			$this->db->query($detail);
			echo 1;
		}
	}

	function hapus_bi_dtl(){
		$id_bi = $_POST['id_bi'];
		$hapus = "delete from t_bi_detail where id_bi='$id_bi'";
		$this->db->query($hapus);
		echo 1;
	}
	
	function simpan_bi_dtl(){
		$username = $this->session->userdata('username');

		$no_bukti = $_POST['no_bukti'];
		$jumlahdata = $_POST['jumlahdata'];

		// --- update flag od ---
		$update = "update t_bi set flag_bi = 1 where no_bukti_bi = '$no_bukti'";
		$this->db->query($update);

		for($i=1;$i<$jumlahdata;$i++){
			$update_dtl = "update t_bi_detail set hrg_satuan=".($_POST['data_i'.$i]).",kuantum= ".$_POST['data_j'.$i]." where id_bi='".$_POST['data_k'.$i]."'";
			$this->db->query($update_dtl);
		}

		// --- update harga beli ---
		$query = "select a.*,b.tgl_bi from t_bi_detail a left join t_bi b on a.no_bukti_bi = b.no_bukti_bi where a.no_bukti_bi='$no_bukti'";
		$rdt = $this->db->query($query);
		$rows = array();
		$i=0;
		foreach($rdt->result() as $dt){
			$rows[$i]['id_bi'] = $dt->id_bi;
			$rows[$i]['kd_barang'] = $dt->kd_barang;
			$rows[$i]['hrg_satuan'] = $dt->hrg_satuan;
			$rows[$i]['kuantum'] = $dt->kuantum;
			$rows[$i]['tgl_bi'] = $dt->tgl_bi;
			$rows[$i]['no_bukti_bi'] = $dt->no_bukti_bi;
			
			// --- insert m_harga_beli ---
			$param = array();
			$param['username'] = $username;
			$param['kd_barang'] = $dt->kd_barang;
			$param['hrg_satuan'] = $dt->hrg_satuan;

			$Hargabeli = $this->penerimaan_model->ins_harga_beli($param);

			$Hargajual = $this->penerimaan_model->ins_harga_jual($param);

			// --- insert mutasi kartubarang---
			$param = array();
			$param['username'] = $username;
			$param['kd_barang'] = $dt->kd_barang;
			$param['hrg_satuan'] = $dt->hrg_satuan;
			$param['kuantum'] = $dt->kuantum;
			$param['tanggal'] = $dt->tgl_bi;
			$param['kd_bukti'] = $dt->no_bukti_bi;
			$Mutasimasuk = $this->penerimaan_model->mutasi_barangmasuk($param);
		}
		echo 1;
	}
}
