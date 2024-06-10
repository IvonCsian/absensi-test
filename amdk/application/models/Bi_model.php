<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bi_model extends CI_Model{

	function __construct(){
		$this->load->database();
	}

	function dataPesanan($data){
        $no_bukti_po = $data['no_bukti_po'];

        $querydt = "select a.*,b.nm_barang from t_order_detail a 
        left join m_barang b on a.kd_barang = b.kd_barang where a.no_bukti_po = '$no_bukti_po'";
        $query = $this->db->query($querydt);
        return $query->result();
    }

	function cekPesanan(){
        $username = $this->session->userdata('username');

        $query = "SELECT * FROM t_order WHERE flag_od=1 AND is_del = 0 and user_id='$username'";
        $result = $this->db->query($query)->num_rows();
        return $result;
    }

    function jmPesanan(){
        $username = $this->session->userdata('username');

        $querydt = "SELECT * FROM t_order WHERE flag_od=1 AND is_del = 0 and user_id='$username'";
        $query = $this->db->query($querydt);
        return $query->result();
    }
    
    function get_bukti($data){
		$kd = $data['kd'];
		$tanggal = $data['tanggal'];
		$str = explode("-", $tanggal);
		$thn = $str[0];
		$bln = $str[1];
		$day = $str[2];
		$tahun = substr($thn,2,2);
		
        $code = 'BI';
        $kode = $code.$bln.$tahun;
        $sql = "SELECT MAX(no_bukti_bi) AS maxID FROM t_bi WHERE no_bukti_bi like '$kode%'";
	
		$result = $this->db->query($sql)->result();
		$noUrut = (int) substr($result[0]->maxID, -4);
		$noUrut++;
		$newId = sprintf("%04s", $noUrut);
		$id= $kode.$newId;
		return $id;
	}

    function ins_harga_beli($data){
        $username = $data['username'];
        $kd_barang = $data['kd_barang'];
        $hrg_satuan = $data['hrg_satuan'];

        if($username != ''){
            $querycek = "SELECT * FROM m_harga_agen WHERE kd_agen = '$username' AND kd_barang = '$kd_barang'";
            $baris = $this->db->query($querycek)->num_rows();
            if($baris > 0){
                $update = "update m_harga_agen set hrg_satuan = '$hrg_satuan',tgl_update=NOW() WHERE kd_agen = '$username' AND kd_barang = '$kd_barang'";
                $this->db->query($update);
            }
            else{
                $query = "INSERT INTO m_harga_agen (kd_agen,kd_barang,hrg_satuan) VALUES ('$username','$kd_barang','$hrg_satuan')";
                $this->db->query($query);
            }
        }
    }

    function ins_harga_jual($data){
        $username = $data['username'];
        $kd_barang = $data['kd_barang'];
     
        if($username != ''){
            $querycek = "SELECT * FROM m_harga_jual WHERE kd_agen = '$username' AND kd_barang = '$kd_barang'";
            $baris = $this->db->query($querycek)->num_rows();
            if($baris > 0){
                $update = "update m_harga_jual set kd_barang = '$kd_barang',tgl_update=NOW() WHERE kd_agen = '$username' AND kd_barang = '$kd_barang'";
                $this->db->query($update);
            }
            else{
                $query = "INSERT INTO m_harga_jual (kd_agen,kd_barang) VALUES ('$username','$kd_barang')";
                $this->db->query($query);
            }
        }
    }

    function mutasi_barangmasuk($data){
        $username = $data['username'];
        $kd_barang = $data['kd_barang'];
        $hrg_satuan = $data['hrg_satuan'];
        $kuantum = $data['kuantum'];
        $tanggal = $data['tanggal'];
        $kd_bukti = $data['kd_bukti'];

        $str = explode("-", $tanggal);
        $tahun = $str[0];
        $bulan = $str[1];

		// --- insert t_stok ---
		$cekstok = "select * from t_stok_barang where  kd_agen='$username' AND kd_barang = '$kd_barang'";
		$resultdt = $this->db->query($cekstok);		
		$data_stok = $resultdt->num_rows();
		if($data_stok == 0 ){
			$insert = "insert into t_stok_barang set kd_agen = '$username',kd_barang='$kd_barang',stok_barang='$kuantum',hrg_beli='$hrg_satuan'";
			$this->db->query($insert);
		}
		else{
			$result = $this->db->query($cekstok)->result();
			$stok_barang = $result[0]->stok_barang;

			$stok_update = $stok_barang + $kuantum;
			$update = "update t_stok_barang set stok_barang='$stok_update',hrg_beli='$hrg_satuan' where kd_barang = '$kd_barang' and kd_agen = '$username'";
			$this->db->query($update);
		}

		// --- insert kartu barang ----
        $cekmutbar = "select * from t_kartubarang where kd_agen='$username' AND kd_barang = '$kd_barang' ORDER BY id DESC LIMIT 1";
		$result = $this->db->query($cekmutbar);		
		$data_mutbar = $result->num_rows();
		if($data_mutbar ==0 ){
			if($bulan == 1){
				 $tahunlalu = $tahun - 1;
				 $cek_saldo = "select * from t_kartubarang where bulan = 12 and tahun = $tahunlalu AND kd_barang = '$kd_barang' and kd_agen='$username' ORDER BY id DESC LIMIT 1";
				 $result1 = $this->db->query($cek_saldo);
				 $data_kb = $result1->num_rows();
				 
				 if($data_kb != 0){
					 $y	= 0;
					 $rows = array(); 
					 foreach ($result1->result() as $m) {
						$rows[$y]['kwt_akhir'] = $m->kwt_akhir;
						$rows[$y]['hsat_akhir'] = $m->hsat_akhir;
						$rows[$y]['jmlh_akhir'] = $m->jmlh_akhir;
						
						$kwtakhir = $m->kwt_akhir + $kuantum;		
						$jmlhin = 	$b->kuantum * $hrg_satuan;
						$update_hsatakhir = round(($jmlhin + $m->jmlh_akhir) / $kwtakhir,2);
						$update_jmlhakhir = $m->jmlh_akhir * $kwtakhir;
						
						$insert = "insert into t_kartubarang set bulan=$bulan,tahun=$tahun,kd_barang='$kd_barang',
						kwt_awal=$m->kwt_akhir,jmlh_awal=$m->jmlh_akhir,hsat_awal=$m->kwt_akhir,
						kwt_akhir=$kwtakhir,jmlh_akhir=$update_jmlhakhir,hsat_akhir=$update_hsatakhir,
						kwt_in=$kuantum,hsat_in=$hrg_satuan,jmlh_in=$jmlhin,
						no_bukti='$kd_bukti',tanggal='$tanggal',kd_agen='$username'";
						$rslt = $this->db->query($insert);	
					 } 
				 }
				 else{
						$jmlhin = 	$kuantum * $hrg_satuan;
						$insert = "insert into t_kartubarang set bulan=$bulan,tahun=$tahun,kd_barang='$kd_barang',
						kwt_akhir=$kuantum,jmlh_akhir=$jmlhin,hsat_akhir=$hrg_satuan,
						kwt_in=$kuantum,hsat_in=$hrg_satuan,jmlh_in=$jmlhin,
						no_bukti='$kd_bukti',tanggal='$tanggal',kd_agen='$username'";

						$rslt = $this->db->query($insert);	
				 }
			}
			else{
				 $bulanlalu = $bulan - 1;
				 $cek_saldo = "select * from t_kartubarang where bulan = $bulanlalu and tahun = $tahun and kd_agen='$username'  AND kd_barang = '$kd_barang' ORDER BY id DESC LIMIT 1";
				 $result1 = $this->db->query($cek_saldo);
				 $data_kb = $result1->num_rows();
				 
				 if($data_kb != 0){
					 $y	= 0;
					 $rows = array(); 
					 foreach ($result1->result() as $m) {
						$rows[$y]['kwt_akhir'] = $m->kwt_akhir;
						$rows[$y]['hsat_akhir'] = $m->hsat_akhir;
						$rows[$y]['jmlh_akhir'] = $m->jmlh_akhir;
						
						$kwtakhir = $m->kwt_akhir + $kuantum;		
						$jmlhin = 	$b->kuantum * $hrg_satuan;
						$update_hsatakhir = round(($jmlhin + $m->jmlh_akhir) / $kwtakhir,2);
						$update_jmlhakhir = $m->jmlh_akhir * $kwtakhir;
						
						$insert = "insert into t_kartubarang set bulan=$bulan,tahun=$tahun,kd_barang='$kd_barang',
						kwt_awal=$m->kwt_akhir,jmlh_awal=$m->jmlh_akhir,hsat_awal=$m->kwt_akhir,
						kwt_akhir=$kwtakhir,jmlh_akhir=$update_jmlhakhir,hsat_akhir=$update_hsatakhir,
						kwt_in=$kuantum,hsat_in=$hrg_satuan,jmlh_in=$jmlhin,
						no_bukti='$kd_bukti',tanggal='$tanggal',kd_agen='$username'";

						$rslt = $this->db->query($insert);	
					 } 
				 }
				 else{
						$jmlhin = 	$kuantum * $hrg_satuan;
						$insert = "insert into t_kartubarang set bulan=$bulan,tahun=$tahun,kd_barang='$kd_barang',
						kwt_akhir=$kuantum,jmlh_akhir=$jmlhin,hsat_akhir=$hrg_satuan,
						kwt_in=$kuantum,hsat_in=$hrg_satuan,jmlh_in=$jmlhin,
						no_bukti='$kd_bukti',tanggal='$tanggal',kd_agen='$username'";
						$rslt = $this->db->query($insert);	
				 }
			}
		}
		else{
			$cek_saldo = "select * from t_kartubarang where bulan=$bulan and tahun=$tahun and kd_agen='$username' and kd_barang='$kd_barang' ORDER BY id DESC LIMIT 1";
			$result3 = $this->db->query($cek_saldo);
			
			$rdt = $result3->result();
			
			$kwt_akhir = $rdt[0]->kwt_akhir;
			$hsat_akhir = $rdt[0]->hsat_akhir;
			$jmlh_akhir = $rdt[0]->jmlh_akhir;
			
			$jmlhin = $hrg_satuan * $kuantum;
			
			$kwtakhir = $kwt_akhir + $kuantum;
			$update_hsatakhir = round(($jmlhin + $jmlh_akhir) / $kwtakhir,2);
			$update_jmlhakhir = $update_hsatakhir * $kwtakhir;
			
			$insert = "insert into t_kartubarang set bulan=$bulan,tahun=$tahun,kd_barang='$kd_barang',
			kwt_awal=$kwt_akhir,jmlh_awal=$jmlh_akhir,hsat_awal=$hsat_akhir,
			kwt_in=$kuantum,hsat_in=$hrg_satuan,jmlh_in=$jmlhin,
			kwt_akhir='$kwtakhir',jmlh_akhir='$update_jmlhakhir',hsat_akhir='$update_hsatakhir',
			no_bukti='$kd_bukti',tanggal='$tanggal',kd_agen='$username'";	
			$rslt = $this->db->query($insert);	
		}

    }

}
?>