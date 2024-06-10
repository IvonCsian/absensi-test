<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}
	
    function jumlah_barang(){
        $this->db->select('*');
        $this->db->from('m_barang');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function dataBarangAgen(){
        $username = $this->session->userdata('username');

		$querycek = "SELECT *,0 as hrg_satuan FROM m_barang";
		$query = $this->db->query($querycek);
		return $query->result();
       
    }

	function get_bukti($data){
		$kd = $data['kd'];
		$tanggal = $data['tanggal'];
		$str = explode("-", $tanggal);
		$thn = $str[0];
		$bln = $str[1];
		$day = $str[2];
		$tahun = substr($thn,2,2);
		
		$code = 'OD';
		$kode = $code.$bln.$tahun;
		$sql = "SELECT MAX(no_bukti_order) AS maxID FROM t_checkout WHERE no_bukti_order like '$kode%'";
	
		$result = $this->db->query($sql)->result();
		$noUrut = (int) substr($result[0]->maxID, -4);
		$noUrut++;
		$newId = sprintf("%04s", $noUrut);
		$id= $kode.$newId;
		return $id;
	}

	function dataOrder(){
        $username = $this->session->userdata('username');

        $querydt = "select b.*,c.nm_barang from t_checkout a 
        left join t_checkout_dtl b on a.no_bukti_order = b.no_bukti_order 
        left join m_barang c on b.kd_barang = c.kd_barang
        where a.user_id='$username' and a.flag_order=0";
        $query = $this->db->query($querydt);
        return $query->result();
    }

    function cekOrder(){
        $username = $this->session->userdata('username');

        $query = "select * from t_checkout where user_id='$username' and flag_order=0";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

	function ajaxdtprofile(){
		$username = $this->session->userdata('username');
        $query=$this->db->query("select * from m_pelanggan 
        WHERE kd_pelanggan = '$username'");
        return $query->result();
	}

}
?>