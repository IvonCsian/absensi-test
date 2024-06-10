<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}

	
	function cekPesanan(){
        $username = $this->session->userdata('username');

        $query = "select * from t_checkout where user_id='$username' and flag_order=2";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function jmPesanan(){
        $username = $this->session->userdata('username');

        $querydt = "select a.*,b.nm_agen from t_checkout a
        left join m_agen b on a.kd_agen = b.kd_agen 
        where a.user_id='$username' and a.flag_order=2 order by a.tgl_order desc";
        $query = $this->db->query($querydt);
        return $query->result();
    }

}
?>