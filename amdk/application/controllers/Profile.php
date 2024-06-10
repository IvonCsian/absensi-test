<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
		$this->load->model('profile_model');
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

    function profile() {
		$username = $this->session->userdata('username');

		$param = array();
		$param['judul'] = "My Profile";
		$param['username'] = $username;

		$dataProfile = $this->profile_model->ajaxdtprofile($param);
		$data = array();
		$data['username'] = $username;
		$data['nama'] = $dataProfile[0]->nm_agen;
		$data['alamat'] = $dataProfile[0]->alamat;
		$data['telp'] = $dataProfile[0]->telp;
		$data['koordinat'] = $dataProfile[0]->koordinat;

        $this->load->view('general/header',$param);
        $this->load->view('general/sidebar');
        $this->load->view('profile/dtprofile',$data);
        $this->load->view('general/footer');
    }
}
