<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Harga_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}

    function HargaBarangAgen(){
        $username = $this->session->userdata('username');

        $querydt = "SELECT a.*,b.nm_barang,c.hrg_satuan AS hrg_jual FROM m_harga_agen a 
        LEFT JOIN m_barang b ON a.kd_barang = b.kd_barang
        LEFT JOIN m_harga_jual c ON a.kd_barang = c.kd_barang
        WHERE a.kd_agen = '$username' and c.kd_agen= '$username'";
        $query = $this->db->query($querydt);
        return $query->result();
    }

    function ajaxdtbarang($data){
        $username = $this->session->userdata('username');
        $kd_barang = $data['kd_barang'];

        $query=$this->db->query("SELECT a.*,b.nm_barang,c.hrg_satuan AS hrg_jual FROM m_harga_agen a 
        LEFT JOIN m_barang b ON a.kd_barang = b.kd_barang
        LEFT JOIN m_harga_jual c ON a.kd_barang = c.kd_barang
        WHERE a.kd_agen = '$username' and a.kd_barang = '$kd_barang' and c.kd_agen= '$username'");
       
        return $query->result();

    }
}
?>