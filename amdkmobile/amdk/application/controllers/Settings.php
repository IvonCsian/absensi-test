<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->model('func_global');
        $this->load->model('setting_model');
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

    function m_level() {
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('settings/m_level');
        $this->load->view('general/footer');
    }

	function submenu() {
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('settings/m_menu');
        $this->load->view('general/footer');
    }

	function m_user() {
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('settings/m_user');
        $this->load->view('general/footer');
    }

	function aksesmenu() {
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('settings/m_akses');
        $this->load->view('general/footer');
    }
	
    function get_data_level(){
		$list = $this->setting_model->get_datatables_level();
        $data = array();
        $no = 0;
        foreach ($list as $field) {
			
            $no++;
            $row = array();
            $row[] = $no;
			$row[] = $field->id_level;	// 1
			$row[] = $field->level;	// 2
            $data[] = $row;
        }

		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->setting_model->count_all_level(),
            "recordsFiltered" => $this->setting_model->count_filtered_level(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	
	function ins_user_level(){
		$level = $_POST['level'];
		$cekdt = "select * from m_level where level = '$level'";
		$rdt = $this->db->query($cekdt)->num_rows();
		if($rdt <> 0){
			echo 2;
		}
		else{
			$ins = "insert into m_level set level = '$level'";
			$this->db->query($ins);
			echo 1;
		}
	}
	
	function hapususer_level(){
		$level = $_POST['level'];
		
		$cekdt = "select * from t_login where level = '$level'";
		$rdt = $this->db->query($cekdt)->num_rows();
		if($rdt <> 0){
			echo 2;
		}
		else{
			$hapus = "delete from m_level where level = '$level'";
			$this->db->query($hapus);
			echo 1;
		}
	}

	// --- menu ----
	
	function ins_submenu(){
		$id_sub = $_POST['id_sub'];
		$judul_sub = $_POST['judul_sub'];
		$controller = $_POST['controller'];
		$link = $_POST['link'];
		$id_head = $_POST['id_head'];
		
		$ins = "insert into m_menu_sub set id_head = '$id_head',judul_sub='$judul_sub',controller='$controller',link='$link'";
		$this->db->query($ins);
		echo 1;
	}
	
	function hapus_submenu(){
		$id_sub = $_POST['id_sub'];
		
		$cek = "select * from m_akses where id_sub_menu = '$id_sub'";
		$rcek = $this->db->query($cek)->num_rows();
		
		if($rcek == 0){
			$hapus = "delete from m_menu_sub where id_sub = '$id_sub'";
			$this->db->query($hapus);
			echo 1;
		}
		else{
			echo 2;
		}
		
	}

	function get_data_menu(){
		$list = $this->setting_model->get_datatables_menu();
        $data = array();
        $no = 0;
        foreach ($list as $field) {
			
            $no++;
            $row = array();
            $row[] = $no;
			$row[] = $field->id_sub;	// 1
            $row[] = $field->judul_head; // 2
            $row[] = $field->judul_sub; // 3
			$row[] = $field->controller; // 4
			$row[] = $field->link; // 4
            $data[] = $row;
        }

		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->setting_model->count_all(),
            "recordsFiltered" => $this->setting_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	function combo_headmenu(){
        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		$sql = "select * from m_menu_head where id_head is not null and judul_head like '$q%' ";
		$data = $this->db->query($sql)->result_array();

        foreach ($data as $key => $value) {
            $value['id']   = $value['id_head'];
            $value['text'] = $value['judul_head'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}

	function combo_level(){
        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		$sql = "select * from m_level where id_level is not null and level like '$q%' ";
		$data = $this->db->query($sql)->result_array();

        foreach ($data as $key => $value) {
            $value['id']   = $value['level'];
            $value['text'] = $value['level'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}

	function combo_departemen(){
        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		$sql = "select * from m_departemen where id_departemen is not null and nm_departemen like '$q%' ";
		$data = $this->db->query($sql)->result_array();

        foreach ($data as $key => $value) {
            $value['id']   = $value['kd_departemen'];
            $value['text'] = $value['kd_departemen']."-".$value['nm_departemen'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}

	function get_data_user(){
		$list = $this->setting_model->get_datatables_user();
        $data = array();
        $no = 0;
        foreach ($list as $field) {
			
            $no++;
            $row = array();
            $row[] = $no;
			$row[] = $field->id_user;	// 1
            $row[] = $field->nama; // 2
            $row[] = $field->username; // 3
			$row[] = $field->level; // 4
			$row[] = $field->nm_departemen; // 5
            $data[] = $row;
        }

		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->setting_model->count_all_user(),
            "recordsFiltered" => $this->setting_model->count_filtered_user(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	function ins_user(){
		$id = $_POST['id_user'];
		$nama = $_POST['nama'];
		$username = $_POST['username'];
		$level = $_POST['level'];
		$kd_departemen = $_POST['kd_departemen'];
		$password = md5($_POST['password']);
		
		if($id == ''){
			$cekdt = "select count(*) as dt from t_login where username = '$username'";
			$rdt = $this->db->query($cekdt)->result();
			$dt = $rdt[0]->dt;
			
			if($dt <> 0){
				echo 2;
			}
			else{
				$ins = "insert into t_login set username = '$username',kd_departemen='$kd_departemen',nama='$nama',level='$level',password='$password'";
				$this->db->query($ins);
				echo 1;
			}
		}
		else{
				$update = "update t_login set nama = '$nama',level='$level',kd_departemen='$kd_departemen' where id_user = '$id'";
				$this->db->query($update);
				echo 3;
		}
	}
	
	function hapususer(){
		$del = "delete from t_login where id_user = '".$_POST['id_user']."'";
		$this->db->query($del);
		echo 1;
	}
	
	function ajaxdtuser(){
		$id = $_GET['id_user'];
		$query = "select * from t_login where id_user = '$id'";
		$result = $this->db->query($query)->row();
		echo json_encode($result);
	}
	
	function resetpassword(){
		$username = md5($_POST['username']);
		$id_user = $_POST['id_user'];
		
		$update = "update t_login set password='$username' where id_user = '$id_user'";
		$this->db->query($update);
		echo 1;
	}
	
	function update_pass(){
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		
		$update = "update t_login set password='$password' where username = '$username'";
		$this->db->query($update);
		
		echo 1;
	}
	
	// ---- hak akses ---
	function tab_akses(){
		$level = $_POST['level'];
		
		echo "<table id='table_akses' class='table table-bordered dt-responsive' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th hidden='true'>Id Head</th>
				<th>Header Menu</th>
				<th>Id Sub Menu</th>
				<th>Judul Menu</th>
			</tr>
		</thead>
		<tbody>";
		$no=1;
		$param = array();
		$param['level'] = $level;
		$data = $this->setting_model->get_data_aksesmenu("", "", "", 0, 0,$param);
        foreach ($data->result_array() as $key => $value) {

            echo "<tr>
				<td>" . $no . "</td>
				<td hidden='true'>" . $value['id_head'] . "</td>
				<td>" . $value['judul_head'] . "</td>
				<td>" . $value['id_sub_menu'] . "</td>
				<td>" . $value['judul_sub'] . "</td>
			</tr>";
            $no++;
        }

        echo "</tbody>
		</table>
		<style>
			.even.selected td {
				background-color: #F08080; !important;
			}
			.odd.selected td {
				background-color: #F08080; !important;
			}

		</style>
		<script>
			$('#table_akses').dataTable({
				responsive:'true',
				searching: true,
				select: {style: 'single'}
			});
		</script>";
	}

	function hapus_aksesmenu(){
		$level = $_POST['level'];
		$id_head = $_POST['id_head'];
		$id_sub = $_POST['id_sub'];
		
		$hapus = "delete from m_akses where id_head = '$id_head' and id_sub_menu='$id_sub' and level='$level'";
		$this->db->query($hapus);
		echo 1;
	}

	function ins_aksesmenu(){
		$level = $_POST['level'];
		$id_header = $_POST['id_header'];
		$id_sub_menu = $_POST['id_sub_menu'];
		
		$cek = "select * from m_akses where level='$level' and id_head = '$id_header' and id_sub_menu='$id_sub_menu'";
		$rcek = $this->db->query($cek)->num_rows();
		
		if($rcek <> 0){
			echo 2;
		}
		else{
			$ins = "insert into m_akses set level='$level',id_head = '$id_header',id_sub_menu='$id_sub_menu'";
			$this->db->query($ins);
			echo 1;
		}
		
	}
	
	function combo_submenu_all(){
        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		$sql = "select * from m_menu_sub where judul_sub like '%$q%' ";
		$data = $this->db->query($sql)->result_array();

        //$data = $this->m_combo->get_pelanggan("", $cari, "", 0, 100)->result_array();

        foreach ($data as $key => $value) {
            $value['id']   = $value['id_sub'];
            $value['text'] = $value['judul_sub'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}
}
