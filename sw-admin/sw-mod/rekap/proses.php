<?php session_start(); error_reporting(0);
if(empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])){
    header('location:../../login/');
 exit;}
else {
require_once'../../../sw-library/sw-config.php';
require_once'../../login/login_session.php';
include('../../../sw-library/sw-function.php'); 

switch (@$_GET['action']){
/* -------  LOAD DATA ABSENSI----------*/
case 'reportrekap':
  $error = array();

   if (empty($_GET['kd_bidang'])) {
      $error[] = 'Bidang tidak boleh kosong';
    } else {
      $kd_bidang = mysqli_real_escape_string($connection, $_GET['kd_bidang']);
   }
   
   if (empty($_GET['bulan'])) {
      $error[] = 'Bulan tidak boleh kosong';
    } else {
      $bulan = mysqli_real_escape_string($connection, $_GET['bulan']);
   }
   
   if (empty($_GET['tahun'])) {
      $error[] = 'Tahun tidak boleh kosong';
    } else {
      $tahun = mysqli_real_escape_string($connection, $_GET['tahun']);
   }
   
  $hari       = date("d");
  //$bulan      = date ("m");
 // $tahun      = date("Y");
  $jumlahhari = date("t",mktime(0,0,0,$bulan,$hari,$tahun));
  $s          = date ("w", mktime (0,0,0,$bulan,1,$tahun));
if (empty($error)) { 
echo'
<div class="table-responsive">
<table class="table table-bordered table-hover" id="swdatatable">
        <thead>
            <tr class="info">
                <th class="align-middle" width="20">No</th>
				<th class="align-middle">No.Pegawai</th>
				<th class="align-middle">Nm.Pegawai</th>
                <th class="align-middle text-center">Kehadiran</th>
				<th class="align-middle text-center">Terlambat</th>
            </tr>
        </thead>
        <tbody>';
        
         if($row_user['kd_status'] == ""){
	         $wherestatus = "";
	     }
	     else{
	         $wherestatus = " AND status_peg = '".$row_user['kd_status']."'";
	     }
		     
		if($kd_bidang == "all"){
		     $queryPegawai = "SELECT * FROM employees WHERE employees_code is not null ".$wherestatus."";
		}
		else{
		    $queryPegawai = "SELECT * FROM employees WHERE kd_bidang = '$kd_bidang' ".$wherestatus."";
		}
		
		
		$result = $connection->query($queryPegawai);
		$no=1;
        while($row = $result->fetch_assoc()) { 
	
			$query_hadir="SELECT presence_id FROM presence WHERE employees_id='".$row['id']."' AND MONTH(presence_date)='$bulan' AND year(presence_date)='$tahun' AND present_id='1' ORDER BY presence_id DESC";
			$hadir= $connection->query($query_hadir);
			
			$query_telat ="SELECT presence_id FROM presence WHERE employees_id='".$row['id']."' AND MONTH(presence_date)='$bulan' AND year(presence_date)='$tahun' AND time_in>shift_time_in";
			$telat = $connection->query($query_telat);
	  
			echo '<tr>
			<td>'.$no.'</td>
			<td>'.$row['employees_code'].'</td>
			<td>'.$row['employees_name'].'</td>
			<td>'.$hadir->num_rows.'</td>
			<td>'.$telat->num_rows.'</td>
			</tr>';
			$no++;
		}
        echo'
        </tbody>
      </table>
  </div>';
?>
<?php
}
else{
  echo'Data tidak ditemukan';
}

break;

case 'excelreportrekap':
	extract($_GET);
	
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kd_bidang = mysqli_real_escape_string($connection, $_GET['kd_bidang']);
	
	$file = "lap_absensirekap_".$kd_bidang."-".$bulan.$tahun.".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	
	$day = date("d-m-Y");
	
	$Qbidang = "select * from bidang where kd_bidang = '$kd_bidang'";
	$result = $connection->query($Qbidang);
	$dt = $result->fetch_assoc();
	$nm_bidang = $dt['nm_bidang'];
	
	echo"
	<table>
		<thead>
			<tr>
				<th colspan='5'>LAPORAN REKAP ABSENSI</th>
			</tr>
			<tr>
				<th colspan='5'>BIDANG ".$nm_bidang."</th>
			</tr>
			<tr>
				<th colspan='5'>PERIODE ".$bulan." - ".$tahun."</th>
			</tr>
		</thead>
	</table><p></p>";
	
	echo'
	<table border="1">
        <thead>
            <tr>
                <th class="align-middle" width="20">No</th>
				<th class="align-middle">No.Pegawai</th>
				<th class="align-middle">Nm.Pegawai</th>
                <th class="align-middle text-center">Kehadiran</th>
				<th class="align-middle text-center">Terlambat</th>
            </tr>
        </thead>
        <tbody>';
        
        if($row_user['kd_status'] == ""){
	         $wherestatus = "";
	     }
	     else{
	         $wherestatus = " AND status_peg = '".$row_user['kd_status']."'";
	     }
	     
	    if($kd_bidang == "all"){
		     $queryPegawai = "SELECT * FROM employees WHERE employees_code is not null ".$wherestatus."";
		}
		else{
		    $queryPegawai = "SELECT * FROM employees WHERE kd_bidang = '$kd_bidang' ".$wherestatus."";
		}
		
		$result = $connection->query($queryPegawai);
		$no=1;
        while($row = $result->fetch_assoc()) { 
	
			$query_hadir="SELECT presence_id FROM presence WHERE employees_id='".$row['id']."' AND MONTH(presence_date)='$bulan' AND year(presence_date)='$tahun' AND present_id='1' ORDER BY presence_id DESC";
			$hadir= $connection->query($query_hadir);
			
			$query_telat ="SELECT presence_id FROM presence WHERE employees_id='".$row['id']."' AND MONTH(presence_date)='$bulan' AND year(presence_date)='$tahun' AND time_in>shift_time_in";
			$telat = $connection->query($query_telat);
	  
			echo '<tr>
			<td>'.$no.'</td>
			<td>'.$row['employees_code'].'</td>
			<td>'.$row['employees_name'].'</td>
			<td>'.$hadir->num_rows.'</td>
			<td>'.$telat->num_rows.'</td>
			</tr>';
			$no++;
		}
        echo'
        </tbody>
      </table>';
	
break;

}

}
