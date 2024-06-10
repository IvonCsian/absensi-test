<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model{
	function __construct(){
		$this->load->database();
	}
	
	function cek($username, $password) {
		$query = "select * from t_login where username = '".$username."' and password=md5('".$password."') ";
		return $this->db->query($query);
    }
	
	function dataBarang(){
		$query=$this->db->query("select count(*) as total_barang from m_barang");
		return $query->result();
	}
	
}
?>