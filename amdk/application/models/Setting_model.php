<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model{
	function __construct(){
		$this->load->database();

	}
	
    var $column_order = array('id_sub','judul_sub','controller','link'); //field yang ada di table user
    var $column_search = array('judul_sub','controller','link'); //field yang diizin untuk pencarian 
    var $order = array('id_sub' => 'asc'); // default order 

    var $column_order_level = array('id_level','level'); //field yang ada di table user
    var $column_search_level = array('id_level','level'); //field yang diizin untuk pencarian 
    var $order_level = array('id_level' => 'asc'); // default order 

    var $column_order_user = array('id_user','nama','username','level','nm_departemen'); //field yang ada di table user
    var $column_search_user = array('nama','username','nm_departemen'); //field yang diizin untuk pencarian 
    var $order_user = array('id_user' => 'asc'); // default order 
        
    private function _get_datatables_query()
    {
        $this->db->select('m_menu_sub.*,m_menu_head.judul_head'); 
        $this->db->from('m_menu_sub');
        $this->db->join('m_menu_head', 'm_menu_head.id_head = m_menu_sub.id_head');

        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_menu()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from('m_menu_sub');
        return $this->db->count_all_results();
    }
	
    /// ----- GROUP LEVEEL ----
	
    function get_datatables_level()
    {
        $this->_get_datatables_querylevel();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	
    private function _get_datatables_querylevel()
    {
        $this->db->select('*'); 
        $this->db->from('m_level');
      
        $i = 0;
     
        foreach ($this->column_search_level as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_level) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order_level[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order_level;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_level()
    {
        $this->_get_datatables_querylevel();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_level()
    {
        $this->db->from('m_level');
        return $this->db->count_all_results();
    }

    /// ----- master user ----
	
    function get_datatables_user()
    {
        $this->_get_datatables_queryuser();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	
    private function _get_datatables_queryuser()
    {
        $this->db->select('t_login.*,if(t_login.kd_departemen="ALL","ALL",m_departemen.nm_departemen) as nm_departemen'); 
        $this->db->from('t_login');
        $this->db->join('m_departemen', 'm_departemen.kd_departemen = t_login.kd_departemen','left');

        $i = 0;
     
        foreach ($this->column_order_user as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_order_user) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order_user[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order_user;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_user()
    {
        $this->_get_datatables_queryuser();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_user()
    {
        $this->db->from('t_login');
        return $this->db->count_all_results();

    }

    function get_data_aksesmenu($cari = "", $sort = "", $order = "", $offset = "0", $limit = "",$data, $numrows = 0) {
		$level = $data['level'];
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.judul_head,c.judul_sub ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("c.judul_sub", "b.judul_head");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_head asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_akses a 
		LEFT JOIN m_menu_head b ON a.id_head = b.id_head 
		LEFT JOIN m_menu_sub c ON a.id_sub_menu = c.id_sub
		WHERE a.level = '$level' " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }
}
?>