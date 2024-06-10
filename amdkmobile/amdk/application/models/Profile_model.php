<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}

    function ajaxdtprofile($data){
        $username = $this->session->userdata('username');
       
        $query=$this->db->query("select * from m_agen 
        WHERE kd_agen = '$username'");
       
        return $query->result();

    }
}
?>