<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agen_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}
	
    function jumlah_barang(){
        $this->db->select('*');
        $this->db->from('m_barang');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function databarang(){
        $username = $this->session->userdata('username');

        $querydt = "SELECT a.*,b.nm_barang,c.hrg_satuan AS hrg_jual FROM m_harga_agen a 
        LEFT JOIN m_barang b ON a.kd_barang = b.kd_barang
        LEFT JOIN m_harga_jual c ON a.kd_barang = c.kd_barang
        WHERE a.kd_agen = '$username' and c.kd_agen='$username'";
        $query = $this->db->query($querydt);
        
        return $query->result();
    }

    function dataOrder(){
        $username = $this->session->userdata('username');

        $querydt = "select b.*,c.nm_barang from t_order a 
        left join t_order_detail b on a.no_bukti_po = b.no_bukti_po 
        left join m_barang c on b.kd_barang = c.kd_barang
        where a.user_id='$username' and a.flag_od=0";
        $query = $this->db->query($querydt);
        return $query->result();
    }

    function cekOrder(){
        $username = $this->session->userdata('username');

        $query = "select * from t_order where user_id='$username' and flag_od=0";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function get_bukti($data){
		$kd = $data['kd'];
		$tanggal = $data['tanggal'];
		$str = explode("-", $tanggal);
		$thn = $str[0];
		$bln = $str[1];
		$day = $str[2];
		$tahun = substr($thn,2,2);
		
		if($kd == 'order'){
			$code = 'OD';
			$kode = $code.$bln.$tahun;
			$sql = "SELECT MAX(no_bukti_po) AS maxID FROM t_order WHERE no_bukti_po like '$kode%'";
		}
		
	
		$result = $this->db->query($sql)->result();
		$noUrut = (int) substr($result[0]->maxID, -4);
		$noUrut++;
		$newId = sprintf("%04s", $noUrut);
		$id= $kode.$newId;
		return $id;
	}
}
?>