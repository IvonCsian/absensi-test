<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Harga extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('harga_model');
		$this->load->model('stok_model');
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

    function hargabarang() {
        $param = array();
		$param['judul'] = "Harga Barang";

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('agen/harga_barang');
        $this->load->view('general/footer');
    }

	function hargajual() {
		$kd_barang = $_GET['kd_barang'];

        $param = array();
		$param['judul'] = "Input Harga Barang";
		$param['kd_barang'] = $kd_barang;
	
		$dataBarang = $this->harga_model->ajaxdtbarang($param);
		$data  = array();
		$data['nm_barang'] = $dataBarang[0]->nm_barang;
		$data['hrg_beli'] = $dataBarang[0]->hrg_satuan;
		$data['hrg_jual'] = $dataBarang[0]->hrg_jual;

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('agen/inp_harga',$data);
        $this->load->view('general/footer');
    }

	function update_harga_jual(){
		$username = $this->session->userdata("username");
		$kd_barang = $_POST['kd_barang'];
		$hrg_jual = $_POST['hrg_jual'];

		$update = "update m_harga_jual set hrg_satuan = '$hrg_jual' where kd_barang = '$kd_barang' and kd_agen = '$username'";
		$this->db->query($update);
		echo 1;
	}
}
