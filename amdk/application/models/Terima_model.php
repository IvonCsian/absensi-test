<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Terima_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}

	function dataPesanan($data){
        $no_bukti_order = $data['no_bukti_order'];

        $username = $this->session->userdata('username');

        $querydt = "select b.*,c.nm_barang from t_checkout a 
        left join t_checkout_dtl b on a.no_bukti_order = b.no_bukti_order 
        left join m_barang c on b.kd_barang = c.kd_barang
        where a.no_bukti_order='$no_bukti_order'";
        $query = $this->db->query($querydt);
        return $query->result();
    }

	function cekPesanan(){
        $username = $this->session->userdata('username');

        $query = "SELECT m.* FROM (SELECT a.*,b.kd_barang,b.kuantum,c.stok_barang FROM t_checkout a 
        LEFT JOIN t_checkout_dtl b ON a.no_bukti_order = b.no_bukti_order 
        INNER JOIN (SELECT * FROM t_stok_barang WHERE kd_agen = '$username') c ON b.kd_barang = c.kd_barang
        WHERE a.flag_order <> 0 and a.flag_done = 0) m WHERE m.stok_barang >= m.kuantum GROUP BY m.no_bukti_order";

        $rdt = $this->db->query($query);
        $i = 0;
        $rows = array();
        $order=0;
        foreach($rdt->result() as $dt){
            $rows[$i]['no_bukti_order'] = $dt->no_bukti_order;

            $query = "SELECT m.*,SUM(flag_od=0) AS dt FROM (SELECT b.*,c.stok_barang,IF(c.stok_barang > b.kuantum,1,0) AS flag_od FROM t_checkout_dtl b 
            LEFT JOIN (SELECT * FROM t_stok_barang WHERE kd_agen = '$username') c ON b.kd_barang = c.kd_barang
            WHERE b.no_bukti_order = '$dt->no_bukti_order') m";
            $result = $this->db->query($query)->result();
            $dt = $result[0]->dt;

            if($dt == 0){
                $order++;
            }
        }
        //$result = $this->db->query($query)->num_rows();
        return $order;
    }

    function jmPesanan(){
        $username = $this->session->userdata('username');

        $querydt = "SELECT m.*,SUM(flag_od=0) AS dt FROM (SELECT a.*,b.kd_barang,b.kuantum,c.stok_barang,IF(c.stok_barang > b.kuantum,1,0) AS flag_od FROM t_checkout a 
        LEFT JOIN t_checkout_dtl b ON a.no_bukti_order = b.no_bukti_order 
        INNER JOIN (SELECT * FROM t_stok_barang WHERE kd_agen = '$username') c ON b.kd_barang = c.kd_barang
        WHERE a.flag_order <> 0 and a.flag_done = 0) m WHERE m.stok_barang >= m.kuantum GROUP BY m.no_bukti_order";
        $query = $this->db->query($querydt);
        return $query->result();
    }
    
    function mutasi_barangkeluar($data){
        $username = $data['username'];
        $kd_barang = $data['kd_barang'];
        $kuantum = $data['kuantum'];
        $tanggal = $data['tanggal'];
        $kd_bukti = $data['kd_bukti'];

        $str = explode("-", $tanggal);
        $tahun = $str[0];
        $bulan = $str[1];

        // --- update t stok ---
        $cekstok = "select * from t_stok_barang where  kd_agen='$username' AND kd_barang = '$kd_barang'";
		$resultdt = $this->db->query($cekstok)->result();
        $stok_barang = 	$resultdt[0]->stok_barang;
        $hrg_beli = 	$resultdt[0]->hrg_beli;

        $updateQty = $stok_barang - $kuantum;
        $update = "update t_stok_barang set stok_barang='$updateQty' where  kd_agen='$username' AND kd_barang = '$kd_barang'";
        $this->db->query($update);

        // --- update kartubarang ----
        $cekmutbar = "select * from t_kartubarang where kd_barang = '$kd_barang' ORDER BY id DESC LIMIT 1";
		$rdt = $this->db->query($cekmutbar)->result();
        
        $kwt_akhir = $rdt[0]->kwt_akhir;
        $hsat_akhir = $rdt[0]->hsat_akhir;
        $jmlh_akhir = $rdt[0]->jmlh_akhir;

        $update_kwtakhir =  $kwt_akhir - $kuantum;
		$update_jmlhakhir = $jmlh_akhir * $update_kwtakhir;

        $hsat_out = $hsat_akhir;
		$jmlh_out = $hsat_out * $kuantum;

        $insert = "insert into t_kartubarang set bulan=$bulan,tahun=$tahun,kd_barang='$kd_barang',
        kwt_awal='$kwt_akhir',jmlh_awal='$jmlh_akhir',hsat_awal='$hsat_akhir',
        kwt_akhir=$update_kwtakhir,jmlh_akhir=$update_jmlhakhir,hsat_akhir=$hsat_akhir,
        kwt_out=$kuantum,hsat_out=$hsat_out,jmlh_out=$jmlh_out,
        no_bukti='$kd_bukti',tanggal='$tanggal'";
        $rslt = $this->db->query($insert);
		
    }

}
?>