<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('m_login');
		$this->load->model('func_global');
        $this->load->model('agen_model');
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
	public function index()
	{
		$this->load->view('vlogin');
	}

	function proses() {
        $usr = str_replace("'","",$this->input->post('username'));
        $psw = str_replace("'","",$this->input->post('password'));
        $u = $usr;
        $p = $psw;
        $cek = $this->m_login->cek($u, $p);
        if ($cek->num_rows() > 0) {
            //login berhasil, buat session
            foreach ($cek->result() as $qad) {
               $sess_data['level'] = $qad->level;
			   $sess_data['username'] = $qad->username;
			   if($qad->level == 'SUPERADMIN'){
				  $sess_data['nama'] = $qad->nama;
			   }
			   else{
				   $query = "select * from t_login where username = '". $sess_data['username']."'";
				   $rdt = $this->db->query($query)->result();
				   $sess_data['nama'] = $rdt[0]->nama;
			   }
				
               $this->session->set_userdata($sess_data);
            }
            redirect('Welcome/sukses');
        } else {
            $this->session->set_flashdata('result_login', '<br>Username atau Password Salah.');
            redirect('Welcome/');
        }
    }

    function sukses() {
        
		$data = array(
            'username' => $this->session->userdata('username'),
            'nama' => $this->session->userdata('nama'),
            'level' => $this->session->userdata('level'),
        );

        $param = array();
        $param['judul'] = 'AMDK MOBILE';

        if($this->session->userdata('level') <> 'USER'){
            $this->load->view('general/header',$param);
            $this->load->view('general/sidebar');
            $this->load->view('home',$data);
            $this->load->view('general/footer');
        }
        else{
            $this->load->view('general/header',$param);
            $this->load->view('general/sidebar');
            $this->load->view('home_user',$data);
            $this->load->view('general/footer');
        }
    }
	
    function logout() {
        $this->session->sess_destroy();
        redirect('Welcome/');
    }
}
