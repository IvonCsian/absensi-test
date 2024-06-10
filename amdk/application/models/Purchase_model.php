<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}
	
    function dataBarangPabrik(){
        $username = $this->session->userdata('username');

		$querycek = "SELECT a.*,b.hrg_barang FROM m_barang a left join m_harga_pabrik b on a.kd_barang = b.kd_barang where b.is_aktif = 1";
		$query = $this->db->query($querycek);
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

        $query = "select * from t_order where user_id='$username' and flag_bi=0";
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
		
		if($kd == 'po'){
			$code = 'PO';
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