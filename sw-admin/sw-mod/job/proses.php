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
case 'reporttgl':
  $error = array();

   if (empty($_GET['kd_bidang'])) {
      $error[] = 'Bidang tidak boleh kosong';
    } else {
      $kd_bidang = mysqli_real_escape_string($connection, $_GET['kd_bidang']);
   }
   
   if (empty($_GET['tanggal'])) {
      $error[] = 'Tanggal tidak boleh kosong';
    } else {
      $tanggal = date('Y-m-d',strtotime($_GET['tanggal']));
   }
   
    if (empty($_GET['status_peg'])) {
      $error[] = 'Status Pegawai tidak boleh kosong';
    } else {
      $status_peg = mysqli_real_escape_string($connection, $_GET['status_peg']);
   }
   
  $hari       = date("d");
  //$bulan      = date ("m");
  $tahun      = date("Y");
  $jumlahhari = date("t",mktime(0,0,0,$bulan,$hari,$tahun));
  $s          = date ("w", mktime (0,0,0,$bulan,1,$tahun));
if (empty($error)) { 
	if($kd_bidang <> 'all'){
	echo'
	<div class="table-responsive">
	<table class="table table-bordered table-hover" id="swdatatable">
			<thead>
				<tr>
					<th class="align-middle" width="20">No</th>
					<th class="align-middle">Tanggal</th>
					<th class="align-middle">Mulai</th>
					<th class="align-middle">Selesai</th>
					<th class="align-middle">No.Pegawai</th>
					<th class="align-middle">Nm.Pegawai</th>
					<th class="align-middle">Pekerjaan</th>
					<th class="align-middle text-center">Persentase</th>
					<th class="align-middle text-center">Sifat</th>
					<th class="align-middle text-center">Tgl.Input</th>
					<th class="align-middle">Tgl.Update</th>
				</tr>
			</thead>
			<tbody>';
			
			if($status_peg == "all"){
				$filterpeg = "";
			}
			else{
				$filterpeg = "AND b.status_peg = '$status_peg'";
			}
			
			$query_absen ="SELECT b.employees_code,b.employees_name,a.job_id,a.tgl_job,a.jam_start,a.jam_end,a.`job`,a.persentase,a.`sifat`,a.`tgl_input`,a.`tg_update` FROM job a LEFT JOIN employees b ON a.employees_id = b.id WHERE a.tgl_job = '$tanggal' AND b.kd_bidang = '$kd_bidang' ".$filterpeg." ORDER BY job_id DESC";
			$result = $connection->query($query_absen);
			$no=1;
			while($row = $result->fetch_assoc()) { 
			
			if($row['kdpeg'] == "K-"){
				$statuspeg = "Organik";
			}
			else if($row['kdpeg'] == "KK"){
				$statuspeg = "Non Organik";
			}
			else if($row['kdpeg'] == "KP"){
				$statuspeg = "KPJ";
			}
			else if($row['kdpeg'] == "PS"){
				$statuspeg = "PSI";
			}
				
			echo '<tr>
				<td>'.$no.'</td>
				<td>'.$row['tgl_job'].'</td>
				<td>'.$row['jam_start'].'</td>
				<td>'.$row['jam_end'].'</td>
				<td>'.$row['employees_code'].'</td>
				<td>'.$row['employees_name'].'</td>
				<td>'.$row['job'].'</td>
				<td>'.$row['persentase'].'</td>
				<td>'.$row['sifat'].' %</td>
				<td>'.$row['tgl_input'].'</td>
				<td>'.$row['tg_update'].'</td>
				</tr>
			';
			$no++;
			}
			echo'
			</tbody>
		  </table>
	  </div>';
	}
	else{
		$QueryBidang = "select * from bidang";
		$resultdt = $connection->query($QueryBidang);
		while($rowdt = $resultdt->fetch_assoc()) {
			$kdbidang = $rowdt['kd_bidang'];
			$nmbidang = $rowdt['nm_bidang'];
			
			echo'
			<div class="table-responsive">
			<table class="table table-bordered table-hover" id="swdatatable">
				<tr>
					<td colspan="10">'.$kdbidang.' - '.$nmbidang.'</td>
				</tr>
			</table>
			<table class="table table-bordered table-hover" id="swdatatable">
					<thead>
						<tr class="info">
							<th class="align-middle" width="20">No</th>
							<th class="align-middle">Tanggal</th>
							<th class="align-middle">Mulai</th>
							<th class="align-middle">Selesai</th>
							<th class="align-middle">No.Pegawai</th>
							<th class="align-middle">Nm.Pegawai</th>
							<th class="align-middle">Pekerjaan</th>
							<th class="align-middle text-center">Persentase</th>
							<th class="align-middle text-center">Sifat</th>
							<th class="align-middle text-center">Tgl.Input</th>
							<th class="align-middle">Tgl.Update</th>
						</tr>
					</thead>
					<tbody>';
				
					if($status_peg == "all"){
						$filterpeg = "";
					}
					else{
						$filterpeg = "AND b.status_peg = '$status_peg'";
					}
					
					$query_absen ="SELECT b.employees_code,b.employees_name,a.job_id,a.tgl_job,a.jam_start,a.jam_end,a.`job`,a.persentase,a.`sifat`,a.`tgl_input`,a.`tg_update` FROM job a LEFT JOIN employees b ON a.employees_id = b.id WHERE a.tgl_job = '$tanggal' AND b.kd_bidang = '$kdbidang' ".$filterpeg." ORDER BY job_id ASC";
					$result = $connection->query($query_absen);
					$no=1;
					while($row = $result->fetch_assoc()) { 
					
					
					if($row['kdpeg'] == "K-"){
						$statuspeg = "Organik";
					}
					else if($row['kdpeg'] == "KK"){
						$statuspeg = "Non Organik";
					}
					else if($row['kdpeg'] == "KP"){
						$statuspeg = "KPJ";
					}
					else if($row['kdpeg'] == "PS"){
						$statuspeg = "PSI";
					}
						
					echo '<tr>
						<td>'.$no.'</td>
						<td>'.$row['tgl_job'].'</td>
						<td>'.$row['jam_start'].'</td>
						<td>'.$row['jam_end'].'</td>
						<td>'.$row['employees_code'].'</td>
						<td>'.$row['employees_name'].'</td>
						<td>'.$row['job'].'</td>
						<td>'.$row['persentase'].' %</td>
						<td>'.$row['sifat'].'</td>
						<td>'.$row['tgl_input'].'</td>
						<td>'.$row['tg_update'].'</td>
						</tr>
					';
					$no++;
					}
					echo'
					</tbody>
				  </table>
			  </div>';
		}
	}
?>
<?php
}
else{
  echo'Data tidak ditemukan';
}

break;

case 'excelreporttgl':
	extract($_GET);
	
	$tanggal = date('Y-m-d',strtotime($_GET['tanggal']));
	$kd_bidang = mysqli_real_escape_string($connection, $_GET['kd_bidang']);
	$status_peg = mysqli_real_escape_string($connection, $_GET['status_peg']);
	
	$file = "lap_absensi_".$kd_bidang."-".$tanggal.".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	
	$day = date("d-m-Y");
	
	if($kd_bidang <> "all"){
	
	$Qbidang = "select * from bidang where kd_bidang = '$kd_bidang'";
	$result = $connection->query($Qbidang);
	$dt = $result->fetch_assoc();
	$nm_bidang = $dt['nm_bidang'];
	
	echo"
	<table>
		<thead>
			<tr>
				<th colspan='10'>LAPORAN PEKERJAAN</th>
			</tr>
			<tr>
				<th colspan='10'>BIDANG ".strtoupper($nm_bidang)."</th>
			</tr>
		</thead>
	</table><p></p>";
	
	echo'
	<table border="1">
        <thead>
            <tr>
                <th class="align-middle" width="20">No</th>
				<th class="align-middle">Tanggal</th>
				<th class="align-middle">Mulai</th>
				<th class="align-middle">Selesai</th>
				<th class="align-middle">No.Pegawai</th>
				<th class="align-middle">Nm.Pegawai</th>
				<th class="align-middle">Pekerjaan</th>
				<th class="align-middle text-center">Persentase</th>
				<th class="align-middle text-center">Sifat</th>
				<th class="align-middle text-center">Tgl.Input</th>
				<th class="align-middle">Tgl.Update</th>
            </tr>
        </thead>
        <tbody>';
		
		if($status_peg == "all"){
			$filterpeg = "";
		}
		else{
			$filterpeg = "AND b.status_peg = '$status_peg'";
		}
		
		$query_absen ="SELECT b.employees_code,b.employees_name,a.job_id,a.tgl_job,a.jam_start,a.jam_end,a.`job`,a.persentase,a.`sifat`,a.`tgl_input`,a.`tg_update` FROM job a LEFT JOIN employees b ON a.employees_id = b.id WHERE a.tgl_job = '$tanggal' AND b.kd_bidang = '$kd_bidang' ".$filterpeg." ORDER BY job_id ASC";
		$result = $connection->query($query_absen);
		$no=1;
        while($row = $result->fetch_assoc()) { 
		
		if($row['kdpeg'] == "K-"){
			$statuspeg = "Organik";
		}
		else if($row['kdpeg'] == "KK"){
			$statuspeg = "Non Organik";
		}
		else if($row['kdpeg'] == "KP"){
			$statuspeg = "KPJ";
		}
		else if($row['kdpeg'] == "PS"){
			$statuspeg = "PSI";
		}
			
		echo '
			<tr>
			<td>'.$no.'</td>
			<td>'.$row['tgl_job'].'</td>
			<td>'.$row['jam_start'].'</td>
			<td>'.$row['jam_end'].'</td>
			<td>'.$row['employees_code'].'</td>
			<td>'.$row['employees_name'].'</td>
			<td>'.$row['job'].'</td>
			<td>'.$row['persentase'].' %</td>
			<td>'.$row['sifat'].'</td>
			<td>'.$row['tgl_input'].'</td>
			<td>'.$row['tg_update'].'</td>
			</tr>
		';
		$no++;
		}
        echo'
        </tbody>
      </table>';
	}
	else{
		echo"
		<table>
			<thead>
				<tr>
					<th colspan='9'>LAPORAN PEKERJAAN</th>
				</tr>
				<tr>
					<th colspan='9'>SEMUA BIDANG</th>
				</tr>
			</thead>
		</table><p></p>";
		
		$QueryBidang = "select * from bidang";
		$resultdt = $connection->query($QueryBidang);
		while($rowdt = $resultdt->fetch_assoc()) {
			$kdbidang = $rowdt['kd_bidang'];
			$nmbidang = $rowdt['nm_bidang'];
			
			echo'
			<table border="1">
				<tr>
					<td colspan="10"><b>'.$kdbidang.' - '.$nmbidang.'</b></td>
				</tr>
			</table>
			<table border="1">
				<thead>
					<tr>
						<th class="align-middle" width="20">No</th>
						<th class="align-middle">Tanggal</th>
						<th class="align-middle">Mulai</th>
						<th class="align-middle">Selesai</th>
						<th class="align-middle">No.Pegawai</th>
						<th class="align-middle">Nm.Pegawai</th>
						<th class="align-middle">Pekerjaan</th>
						<th class="align-middle text-center">Persentase</th>
						<th class="align-middle text-center">Sifat</th>
						<th class="align-middle text-center">Tgl.Input</th>
						<th class="align-middle">Tgl.Update</th>
					</tr>
				</thead>
				<tbody>';
				
				if($status_peg == "all"){
					$filterpeg = "";
				}
				else{
					$filterpeg = "AND b.status_peg = '$status_peg'";
				}
				
				$query_absen ="SELECT b.employees_code,b.employees_name,a.job_id,a.tgl_job,a.jam_start,a.jam_end,a.`job`,a.persentase,a.`sifat`,a.`tgl_input`,a.`tg_update` FROM job a LEFT JOIN employees b ON a.employees_id = b.id WHERE a.tgl_job = '$tanggal' AND b.kd_bidang = '$kdbidang' ".$filterpeg." ORDER BY job_id ASC";
				$result = $connection->query($query_absen);
				$no=1;
				while($row = $result->fetch_assoc()) { 
				
				 
				if($row['kdpeg'] == "K-"){
					$statuspeg = "Organik";
				}
				else if($row['kdpeg'] == "KK"){
					$statuspeg = "Non Organik";
				}
				else if($row['kdpeg'] == "KP"){
					$statuspeg = "KPJ";
				}
				else if($row['kdpeg'] == "PS"){
					$statuspeg = "PSI";
				}
					
				echo '
					<tr>
					<td>'.$no.'</td>
					<td>'.$row['tgl_job'].'</td>
					<td>'.$row['jam_start'].'</td>
					<td>'.$row['jam_end'].'</td>
					<td>'.$row['employees_code'].'</td>
					<td>'.$row['employees_name'].'</td>
					<td>'.$row['job'].'</td>
					<td>'.$row['persentase'].' %</td>
					<td>'.$row['sifat'].'</td>
					<td>'.$row['tgl_input'].'</td>
					<td>'.$row['tg_update'].'</td>
					</tr>
				';
				$no++;
				}
				echo'
				</tbody>
			  </table><p></p>';
		}
	}
	
break;

// === report bulan ===
case 'reportbln':
  $error = array();

   if (empty($_GET['kd_bidang'])) {
      $error[] = 'Bidang tidak boleh kosong';
    } else {
      $kd_bidang = mysqli_real_escape_string($connection, $_GET['kd_bidang']);
   }
   
   if (empty($_GET['tgl_awal'])) {
      $error[] = 'Tanggal Awal tidak boleh kosong';
    } else {
      $tgl_awal = date('Y-m-d',strtotime($_GET['tgl_awal']));
   }
   
    if (empty($_GET['tgl_akhir'])) {
      $error[] = 'Tanggal Akhir tidak boleh kosong';
    } else {
      $tgl_akhir = date('Y-m-d',strtotime($_GET['tgl_akhir']));
   }
   
    if (empty($_GET['status_peg'])) {
      $error[] = 'Status Pegawai tidak boleh kosong';
    } else {
      $status_peg = mysqli_real_escape_string($connection, $_GET['status_peg']);
   }
   
  $hari       = date("d");
//  $jumlahhari = date("t",mktime(0,0,0,$bulan,$hari,$tahun));
  $s          = date ("w", mktime (0,0,0,$bulan,1,$tahun));
if (empty($error)) { 
	if($kd_bidang <> 'all'){
	echo'
	<div class="table-responsive">
	<table class="table table-bordered table-hover" id="swdatatable">
			<thead>
				<tr>
					<th class="align-middle" width="20">No</th>
					<th class="align-middle">Tanggal</th>
					<th class="align-middle">Mulai</th>
					<th class="align-middle">Selesai</th>
					<th class="align-middle">No.Pegawai</th>
					<th class="align-middle">Nm.Pegawai</th>
					<th class="align-middle">Pekerjaan</th>
					<th class="align-middle text-center">Persentase</th>
					<th class="align-middle text-center">Sifat</th>
					<th class="align-middle text-center">Tgl.Input</th>
					<th class="align-middle">Tgl.Update</th>
				</tr>
			</thead>
			<tbody>';
			
			if($status_peg == "all"){
				$filterpeg = "";
			}
			else{
				$filterpeg = "AND b.status_peg = '$status_peg'";
			}
			
			$query_maspeg = "SELECT b.employees_code,b.employees_name,a.job_id,a.tgl_job,a.jam_start,a.jam_end,a.`job`,a.persentase,a.`sifat`,a.`tgl_input`,a.`tg_update` FROM job a LEFT JOIN employees b ON a.employees_id = b.id WHERE a.tgl_job between '$tgl_awal' AND '$tgl_akhir' AND b.kd_bidang = '$kd_bidang' ".$filterpeg."  ORDER BY job_id ASC";
			
			$result = $connection->query($query_maspeg);
			$no=1;
			while($row = $result->fetch_assoc()) {
				$employees_id = $row['id'];
				$statuspeg = $row['status_peg'];
				
				$begin = new DateTime($tgl_awal);
				$end   = new DateTime($tgl_akhir);

					echo '
					<tr>
						<td>'.$no.'</td>
						<td>'.$row['tgl_job'].'</td>
						<td>'.$row['jam_start'].'</td>
						<td>'.$row['jam_end'].'</td>
						<td>'.$row['employees_code'].'</td>
						<td>'.$row['employees_name'].'</td>
						<td>'.$row['job'].'</td>
						<td>'.$row['persentase'].' %</td>
						<td>'.$row['sifat'].'</td>
						<td>'.$row['tgl_input'].'</td>
						<td>'.$row['tg_update'].'</td>
					</tr>';
					$no++;
				
				
				
			}
			echo'
			</tbody>
		  </table>
	  </div>';
	}
	else{
		$QueryBidang = "select * from bidang";
		$resultdt = $connection->query($QueryBidang);
		while($rowdt = $resultdt->fetch_assoc()) {
			$kdbidang = $rowdt['kd_bidang'];
			$nmbidang = $rowdt['nm_bidang'];
			$kd_bidang = $kdbidang;
			echo'
			<div class="table-responsive">
			<table class="table table-bordered table-hover" id="swdatatable">
				<tr>
					<td colspan="10">'.$kdbidang.' - '.$nmbidang.'</td>
				</tr>
			</table>
			<table class="table table-bordered table-hover" id="swdatatable">
					<thead>
						<tr class="info">
							<th class="align-middle" width="20">No</th>
							<th class="align-middle">Tanggal</th>
							<th class="align-middle">Mulai</th>
							<th class="align-middle">Selesai</th>
							<th class="align-middle">No.Pegawai</th>
							<th class="align-middle">Nm.Pegawai</th>
							<th class="align-middle">Pekerjaan</th>
							<th class="align-middle text-center">Persentase</th>
							<th class="align-middle text-center">Sifat</th>
							<th class="align-middle text-center">Tgl.Input</th>
							<th class="align-middle">Tgl.Update</th>
						</tr>
					</thead>
					<tbody>';
					
					if($status_peg == "all"){
						$filterpeg = "";
					}
					else{
						$filterpeg = "AND b.status_peg = '$status_peg'";
					}
				
					$query_maspeg = "SELECT b.employees_code,b.employees_name,a.job_id,a.tgl_job,a.jam_start,a.jam_end,a.`job`,a.persentase,a.`sifat`,a.`tgl_input`,a.`tg_update` FROM job a LEFT JOIN employees b ON a.employees_id = b.id WHERE a.tgl_job between '$tgl_awal' AND '$tgl_akhir' AND b.kd_bidang = '$kd_bidang' ".$filterpeg."  ORDER BY job_id ASC";
					//echo $query_maspeg;
					$result = $connection->query($query_maspeg);
					$no=1;
					while($row = $result->fetch_assoc()) {
						$employees_id = $row['id'];
						$statuspeg = $row['status_peg'];
						
						$begin = new DateTime($tgl_awal);
						$end   = new DateTime($tgl_akhir);

							echo '
							<tr>
								<td>'.$no.'</td>
								<td>'.$row['tgl_job'].'</td>
								<td>'.$row['jam_start'].'</td>
								<td>'.$row['jam_end'].'</td>
								<td>'.$row['employees_code'].'</td>
								<td>'.$row['employees_name'].'</td>
								<td>'.$row['job'].'</td>
								<td>'.$row['persentase'].' %</td>
								<td>'.$row['sifat'].'</td>
								<td>'.$row['tgl_input'].'</td>
								<td>'.$row['tg_update'].'</td>
							</tr>';
							$no++;
						
					}
				
					$no++;
				echo'
				</tbody>
			  </table>
		  </div>';
		} // --- end of looping bidang ---
	}
?>
<?php
}
else{
  echo'Data tidak ditemukan';
}

break;

case 'excelreportbln':
	extract($_GET);
	
	$tgl_akhir = date('Y-m-d',strtotime($_GET['tgl_akhir']));
	$tgl_awal = date('Y-m-d',strtotime($_GET['tgl_awal']));
	$kd_bidang = mysqli_real_escape_string($connection, $_GET['kd_bidang']);
	$status_peg = mysqli_real_escape_string($connection, $_GET['status_peg']);
	
	$file = "lap_absensi_".$kd_bidang."-".$bulan.$tahun.".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	
	$day = date("d-m-Y");
	
	if($kd_bidang <> "all"){
	
	$Qbidang = "select * from bidang where kd_bidang = '$kd_bidang'";
	$result = $connection->query($Qbidang);
	$dt = $result->fetch_assoc();
	$nm_bidang = $dt['nm_bidang'];
	
	echo"
	<table>
		<thead>
			<tr>
				<th colspan='10'>LAPORAN PEKERJAAN</th>
			</tr>
			<tr>
				<th colspan='10'>BIDANG ".strtoupper($nm_bidang)."</th>
			</tr>
		</thead>
	</table><p></p>";
	
	echo'
	<table border="1">
        <thead>
            <tr>
                <th class="align-middle" width="20">No</th>
				<th class="align-middle">Tanggal</th>
				<th class="align-middle">Mulai</th>
				<th class="align-middle">Selesai</th>
				<th class="align-middle">No.Pegawai</th>
				<th class="align-middle">Nm.Pegawai</th>
				<th class="align-middle">Pekerjaan</th>
				<th class="align-middle text-center">Persentase</th>
				<th class="align-middle text-center">Sifat</th>
				<th class="align-middle text-center">Tgl.Input</th>
				<th class="align-middle">Tgl.Update</th>
            </tr>
        </thead>
        <tbody>';
		
		if($status_peg == "all"){
			$filterpeg = "";
		}
		else{
			$filterpeg = "AND b.status_peg = '$status_peg'";
		}
		
		//$query_maspeg = "select b.*,SUBSTR(b.employees_code,1,2) AS kdpeg from employees b where b.kd_bidang = '$kd_bidang' ".$filterpeg." order by b.employees_code asc";
		$query_maspeg = "SELECT b.employees_code,b.employees_name,a.job_id,a.tgl_job,a.jam_start, a.jam_end,a.`job`,a.persentase,a.`sifat`,a.`tgl_input`,a.`tg_update` FROM job a LEFT JOIN employees b ON a.employees_id = b.id WHERE a.tgl_job between '$tgl_awal' AND '$tgl_akhir' AND b.kd_bidang = '$kd_bidang' ".$filterpeg."  ORDER BY job_id ASC";

		$result = $connection->query($query_maspeg);
		$no=1;
		while($row = $result->fetch_assoc()) {
			$employees_id = $row['id'];
			$statuspeg = $row['status_peg'];
			
			$begin = new DateTime($tgl_awal);
			$end   = new DateTime($tgl_akhir);
				echo '
				<tr>
					<td>'.$no.'</td>
					<td>'.$row['tgl_job'].'</td>
					<td>'.$row['jam_start'].'</td>
					<td>'.$row['jam_end'].'</td>
					<td>'.$row['employees_code'].'</td>
					<td>'.$row['employees_name'].'</td>
					<td>'.$row['job'].'</td>
					<td>'.$row['persentase'].' %</td>
					<td>'.$row['sifat'].'</td>
					<td>'.$row['tgl_input'].'</td>
					<td>'.$row['tg_update'].'</td>
				</tr>';
				$no++;
			
			
			
		}
        echo'
        </tbody>
      </table>';
	}
	else{
		echo"
		<table>
			<thead>
				<tr>
					<th colspan='9'>LAPORAN PEKERJAAN</th>
				</tr>
				<tr>
					<th colspan='9'>SEMUA BIDANG</th>
				</tr>
			</thead>
		</table><p></p>";
		
		$QueryBidang = "select * from bidang";
		$resultdt = $connection->query($QueryBidang);
		
		echo'
		<table border="1">
		<thead>
			<tr>
				<th class="align-middle" width="20">No</th>
				<th class="align-middle">Tanggal</th>
				<th class="align-middle">Mulai</th>
				<th class="align-middle">Selesai</th>
				<th class="align-middle">No.Pegawai</th>
				<th class="align-middle">Nm.Pegawai</th>
				<th class="align-middle">Pekerjaan</th>
				<th class="align-middle text-center">Persentase</th>
				<th class="align-middle text-center">Sifat</th>
				<th class="align-middle text-center">Tgl.Input</th>
				<th class="align-middle">Tgl.Update</th>
			</tr>
		</thead>
		<tbody>';
		while($rowdt = $resultdt->fetch_assoc()) {
			$kdbidang = $rowdt['kd_bidang'];
			$nmbidang = $rowdt['nm_bidang'];
			$kd_bidang = $kdbidang;

				if($status_peg == "all"){
					$filterpeg = "";
				}
				else{
					$filterpeg = "AND b.status_peg = '$status_peg'";
				}
				
				

				$query_maspeg = "SELECT b.employees_code,b.employees_name,a.job_id,a.tgl_job,a.jam_start, a.jam_end,a.`job`,a.persentase,a.`sifat`,a.`tgl_input`,a.`tg_update` FROM job a LEFT JOIN employees b ON a.employees_id = b.id WHERE a.tgl_job between '$tgl_awal' AND '$tgl_akhir' AND b.kd_bidang = '$kd_bidang' ".$filterpeg."  ORDER BY job_id ASC";
			
				$result = $connection->query($query_maspeg);
				$no=1;
				while($row = $result->fetch_assoc()) {
					$employees_id = $row['id'];
					$statuspeg = $row['status_peg'];
					
					$begin = new DateTime($tgl_awal);
					$end   = new DateTime($tgl_akhir);

						echo '
						<tr>
							<td>'.$no.'</td>
						<td>'.$row['tgl_job'].'</td>
						<td>'.$row['jam_start'].'</td>
						<td>'.$row['jam_end'].'</td>
						<td>'.$row['employees_code'].'</td>
						<td>'.$row['employees_name'].'</td>
						<td>'.$row['job'].'</td>
						<td>'.$row['persentase'].' %</td>
						<td>'.$row['sifat'].'</td>
						<td>'.$row['tgl_input'].'</td>
						<td>'.$row['tg_update'].'</td>
						</tr>';
						$no++;
					
				}
				
		}
		echo'
		</tbody>
	  </table>';
	}
	
break;

}

}
