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
					<th class="align-middle">No.Pegawai</th>
					<th class="align-middle">Nm.Pegawai</th>
					<th class="align-middle">Status Pegawai</th>
					<th class="align-middle text-center">Scan Masuk</th>
					<th class="align-middle text-center">Terlambat</th>
					<th class="align-middle text-center">Scan Pulang</th>
					<th class="align-middle text-center" style="display:none">Pulang Cepat</th>
					<th class="align-middle">Status</th>
				</tr>
			</thead>
			<tbody>';
			
			/*
			if($status_peg == "all"){
				$filterpeg = "";
			}
			else if($status_peg == "K"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'K-'";
			}
			else if($status_peg == "KK"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KK'";
			}
			else if($status_peg == "KPJ"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KP'";
			}
			else if($status_peg == "PSI"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PS'";
			}
			*/
			
			if($status_peg == "all"){
				$filterpeg = "";
			}
			else{
				$filterpeg = "AND b.status_peg = '$status_peg'";
			}
			
			$query_absen ="SELECT b.employees_code,b.employees_name,presence_id,presence_date,time_in,time_out,picture_in,picture_out,present_id, latitude_longtitude_in,latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,
			IF (time_in>shift_time_in,'Telat',IF(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS STATUS, 
			TIMEDIFF(TIME(time_out),shift_time_out) AS selisih_out,SUBSTR(b.employees_code,1,2) as kdpeg,b.status_peg FROM presence a 
			LEFT JOIN employees b ON a.employees_id = b.id
			WHERE a.presence_date = '$tanggal' AND b.kd_bidang = '$kd_bidang' ".$filterpeg." ORDER BY presence_id DESC";
		
			$result = $connection->query($query_absen);
			$no=1;
			while($row = $result->fetch_assoc()) { 
			
			 // Status Absensi Jam Masuk
			if($row['STATUS']=='Telat'){
			  $status_time_in ='<label class="label label-danger">Terlambat</label>';
			}
			  elseif ($row['STATUS']=='Tepat Waktu') {
			  $status_time_in ='<label class="label label-info">'.$row_absen['STATUS'].'</label>';
			}
			else{
			  $status_time_in ='<label class="label label-danger">'.$row_absen['STATUS'].'</label>';
			}
			
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
				<td>'.$row['presence_date'].'</td>
				<td>'.$row['employees_code'].'</td>
				<td>'.$row['employees_name'].'</td>
				<td>'.$row['status_peg'].'</td>
				<td>'.$row['time_in'].'</td>
				<td>'.$row['selisih'].'</td>
				<td>'.$row['time_out'].'</td>
				<td style="display:none">'.$row['selisih_out'].'</td>
				<td>'.$status_time_in.'</td>
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
							<th class="align-middle">No.Pegawai</th>
							<th class="align-middle">Nm.Pegawai</th>
							<th class="align-middle">Status Pegawai</th>
							<th class="align-middle text-center">Scan Masuk</th>
							<th class="align-middle text-center">Terlambat</th>
							<th class="align-middle text-center">Scan Pulang</th>
							<th class="align-middle text-center" style="display:none">Pulang Cepat</th>
							<th class="align-middle">Status</th>
						</tr>
					</thead>
					<tbody>';
					/*
					if($status_peg == "all"){
						$filterpeg = "";
					}
					else if($status_peg == "K"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'K-'";
					}
					else if($status_peg == "KK"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KK'";
					}
					else if($status_peg == "KPJ"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KP'";
					}
					else if($status_peg == "PSI"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PS'";
					}*/
					
					if($status_peg == "all"){
						$filterpeg = "";
					}
					else{
						$filterpeg = "AND b.status_peg = '$status_peg'";
					}
					
					$query_absen ="SELECT b.employees_code,b.employees_name,presence_id,presence_date,time_in,time_out,picture_in,picture_out,present_id, latitude_longtitude_in,latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,
					IF (time_in>shift_time_in,'Telat',IF(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS STATUS, 
					TIMEDIFF(TIME(time_out),shift_time_out) AS selisih_out,SUBSTR(b.employees_code,1,2) as kdpeg,b.status_peg FROM presence a 
					LEFT JOIN employees b ON a.employees_id = b.id
					WHERE a.presence_date = '$tanggal' AND b.kd_bidang = '$kdbidang' ".$filterpeg." ORDER BY presence_id DESC";
					$result = $connection->query($query_absen);
					$no=1;
					while($row = $result->fetch_assoc()) { 
					
					 // Status Absensi Jam Masuk
					if($row['STATUS']=='Telat'){
					  $status_time_in ='<label class="label label-danger">Terlambat</label>';
					}
					  elseif ($row['STATUS']=='Tepat Waktu') {
					  $status_time_in ='<label class="label label-info">'.$row_absen['STATUS'].'</label>';
					}
					else{
					  $status_time_in ='<label class="label label-danger">'.$row_absen['STATUS'].'</label>';
					}
					
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
						<td>'.$row['presence_date'].'</td>
						<td>'.$row['employees_code'].'</td>
						<td>'.$row['employees_name'].'</td>
						<td>'.$row['status_peg'].'</td>
						<td>'.$row['time_in'].'</td>
						<td>'.$row['selisih'].'</td>
						<td>'.$row['time_out'].'</td>
						<td style="display:none">'.$row['selisih_out'].'</td>
						<td>'.$status_time_in.'</td>
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
				<th colspan='10'>LAPORAN ABSENSI</th>
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
				<th class="align-middle">No.Pegawai</th>
				<th class="align-middle">Nm.Pegawai</th>
				<th class="align-middle">Status Pegawai</th>
                <th class="align-middle text-center">Scan Masuk</th>
                <th class="align-middle text-center">Terlambat</th>
                <th class="align-middle text-center">Scan Pulang</th>
                <th class="align-middle text-center">Pulang Cepat</th>
                <th class="align-middle">Status</th>
            </tr>
        </thead>
        <tbody>';
		/*
		if($status_peg == "all"){
			$filterpeg = "";
		}
		else if($status_peg == "K"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'K-'";
		}
		else if($status_peg == "KK"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KK'";
		}
		else if($status_peg == "KPJ"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KP'";
		}
		else if($status_peg == "PSI"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PS'";
		}
		*/
		
		if($status_peg == "all"){
			$filterpeg = "";
		}
		else{
			$filterpeg = "AND b.status_peg = '$status_peg'";
		}
		
		$query_absen ="SELECT b.employees_code,b.employees_name,presence_id,presence_date,time_in,time_out,picture_in,picture_out,present_id, latitude_longtitude_in,latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,
		IF (time_in>shift_time_in,'Telat',IF(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS STATUS, 
		TIMEDIFF(TIME(time_out),shift_time_out) AS selisih_out,SUBSTR(b.employees_code,1,2) as kdpeg,b.status_peg FROM presence a 
		LEFT JOIN employees b ON a.employees_id = b.id
		WHERE a.presence_date = '$tanggal' AND b.kd_bidang = '$kd_bidang' ".$filterpeg." ORDER BY presence_id DESC";
		$result = $connection->query($query_absen);
		$no=1;
        while($row = $result->fetch_assoc()) { 
		
		 // Status Absensi Jam Masuk
        if($row['STATUS']=='Telat'){
          $status_time_in ='<label class="label label-danger">Terlambat</label>';
        }
          elseif ($row['STATUS']=='Tepat Waktu') {
          $status_time_in ='<label class="label label-info">'.$row_absen['STATUS'].'</label>';
        }
        else{
          $status_time_in ='<label class="label label-danger">'.$row_absen['STATUS'].'</label>';
        }
		
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
			<td>'.$row['presence_date'].'</td>
			<td>'.$row['employees_code'].'</td>
			<td>'.$row['employees_name'].'</td>
			<td>'.$row['status_peg'].'</td>
			<td>'.$row['time_in'].'</td>
			<td>'.$row['selisih'].'</td>
			<td>'.$row['time_out'].'</td>
			<td>'.$row['selisih_out'].'</td>
			<td>'.$status_time_in.'</td>
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
					<th colspan='9'>LAPORAN ABSENSI</th>
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
						<th class="align-middle">No.Pegawai</th>
						<th class="align-middle">Nm.Pegawai</th>
						<th class="align-middle">Status Pegawai</th>
						<th class="align-middle text-center">Scan Masuk</th>
						<th class="align-middle text-center">Terlambat</th>
						<th class="align-middle text-center">Scan Pulang</th>
						<th class="align-middle text-center">Pulang Cepat</th>
						<th class="align-middle">Status</th>
					</tr>
				</thead>
				<tbody>';
				/*
				if($status_peg == "all"){
					$filterpeg = "";
				}
				else if($status_peg == "K"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'K-'";
				}
				else if($status_peg == "KK"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KK'";
				}
				else if($status_peg == "KPJ"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KP'";
				}
				else if($status_peg == "PSI"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PS'";
				}*/
				
				if($status_peg == "all"){
					$filterpeg = "";
				}
				else{
					$filterpeg = "AND b.status_peg = '$status_peg'";
				}
				
				$query_absen ="SELECT b.employees_code,b.employees_name,presence_id,presence_date,time_in,time_out,picture_in,picture_out,present_id, latitude_longtitude_in,latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,
				IF (time_in>shift_time_in,'Telat',IF(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS STATUS, 
				TIMEDIFF(TIME(time_out),shift_time_out) AS selisih_out,SUBSTR(b.employees_code,1,2) as kdpeg,b.status_peg FROM presence a 
				LEFT JOIN employees b ON a.employees_id = b.id
				WHERE a.presence_date = '$tanggal' AND b.kd_bidang = '$kdbidang' ".$filterpeg." ORDER BY presence_id DESC";
				$result = $connection->query($query_absen);
				$no=1;
				while($row = $result->fetch_assoc()) { 
				
				 // Status Absensi Jam Masuk
				if($row['STATUS']=='Telat'){
				  $status_time_in ='<label class="label label-danger">Terlambat</label>';
				}
				  elseif ($row['STATUS']=='Tepat Waktu') {
				  $status_time_in ='<label class="label label-info">'.$row_absen['STATUS'].'</label>';
				}
				else{
				  $status_time_in ='<label class="label label-danger">'.$row_absen['STATUS'].'</label>';
				}
				
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
					<td>'.$row['presence_date'].'</td>
					<td>'.$row['employees_code'].'</td>
					<td>'.$row['employees_name'].'</td>
					<td>'.$row['status_peg'].'</td>
					<td>'.$row['time_in'].'</td>
					<td>'.$row['selisih'].'</td>
					<td>'.$row['time_out'].'</td>
					<td>'.$row['selisih_out'].'</td>
					<td>'.$status_time_in.'</td>
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
  ini_set('max_execution_time', '0');
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
					<th class="align-middle">No.Pegawai</th>
					<th class="align-middle">Nm.Pegawai</th>
					<th class="align-middle">Status Pegawai</th>
					<th class="align-middle text-center">Scan Masuk</th>
					<th class="align-middle text-center">Terlambat</th>
					<th class="align-middle text-center">Scan Pulang</th>
					<th class="align-middle text-center" style="display:none">Pulang Cepat</th>
					<th class="align-middle">Status</th>
				</tr>
			</thead>
			<tbody>';
			/*
			if($status_peg == "all"){
				$filterpeg = "";
			}
			else if($status_peg == "K"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'K-'";
			}
			else if($status_peg == "KK"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KK'";
			}
			else if($status_peg == "KPJ"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KP'";
			}
			else if($status_peg == "PSI"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PS'";
			}
			else if($status_peg == "PKM"){
				$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PK'";
			}*/
			
			if($status_peg == "all"){
				$filterpeg = "";
			}
			else{
				$filterpeg = "AND b.status_peg = '$status_peg'";
			}
			
			$query_maspeg = "select b.*,SUBSTR(b.employees_code,1,2) AS kdpeg from employees b where b.kd_bidang = '$kd_bidang' ".$filterpeg." order by b.employees_code asc";
		
			$result = $connection->query($query_maspeg);
			$no=1;
			while($row = $result->fetch_assoc()) {
				$employees_id = $row['id'];
				$statuspeg = $row['status_peg'];
				/*
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
				else if($row['kdpeg'] == "PK"){
					$statuspeg = "PKM";
				}*/
				
				$begin = new DateTime($tgl_awal);
				$end   = new DateTime($tgl_akhir);

				for($i = $begin; $i <= $end; $i->modify('+1 day')){
					
					$tanggal = date('d-m-Y',strtotime($i->format("Y-m-d")));
					
					$tgl_absen = $i->format("Y-m-d");
					
					$query_absen ="SELECT presence_id,presence_date,time_in,time_out,picture_in,picture_out,present_id, latitude_longtitude_in,latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,
					IF (time_in>shift_time_in,'Telat',IF(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS STATUS, 
					TIMEDIFF(TIME(time_out),shift_time_out) AS selisih_out FROM presence a 
					WHERE a.presence_date = '$tgl_absen' AND a.employees_id = '$employees_id' ORDER BY presence_id ASC";	
					$result2 = $connection->query($query_absen);
					$dt = $result2->fetch_assoc();
					
					 // Status Absensi Jam Masuk
					if($dt['STATUS']=='Telat'){
					  $status_time_in ='<label class="label label-danger">Terlambat</label>';
					}
					elseif ($dt['STATUS']=='Tepat Waktu') {
					  $status_time_in ='<label class="label label-info">'.$row_absen['STATUS'].'</label>';
					}
					else{
					  $status_time_in ='<label class="label label-danger">'.$row_absen['STATUS'].'</label>';
					}
					
					if ($result2->num_rows < 1){
						$status_time_in ='<label class="label label-warning">Tidak Absen</label>';
					}
					
					echo '
					<tr>
						<td>'.$no.'</td>
						<td>'.$tanggal.'</td>
						<td>'.$row['employees_code'].'</td>
						<td>'.$row['employees_name'].'</td>
						<td>'.$statuspeg.'</td>
						<td>'.$dt['time_in'].'</td>
						<td>'.$dt['selisih'].'</td>
						<td>'.$dt['time_out'].'</td>
						<td style="display:none">'.$dt['selisih_out'].'</td>
						<td>'.$status_time_in.'</td>
					</tr>';
					$no++;
				}
				
				
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
							<th class="align-middle">No.Pegawai</th>
							<th class="align-middle">Nm.Pegawai</th>
							<th class="align-middle">Status Pegawai</th>
							<th class="align-middle text-center">Scan Masuk</th>
							<th class="align-middle text-center">Terlambat</th>
							<th class="align-middle text-center">Scan Pulang</th>
							<th class="align-middle text-center" style="display:none">Pulang Cepat</th>
							<th class="align-middle">Status</th>
						</tr>
					</thead>
					<tbody>';
					/*
					if($status_peg == "all"){
						$filterpeg = "";
					}
					else if($status_peg == "K"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'K-'";
					}
					else if($status_peg == "KK"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KK'";
					}
					else if($status_peg == "KPJ"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KP'";
					}
					else if($status_peg == "PSI"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PS'";
					}
					else if($status_peg == "PKM"){
						$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PK'";
					}*/
					
					if($status_peg == "all"){
						$filterpeg = "";
					}
					else{
						$filterpeg = "AND b.status_peg = '$status_peg'";
					}
				
					$query_maspeg = "select b.*,SUBSTR(b.employees_code,1,2) AS kdpeg from employees b where b.kd_bidang = '$kdbidang' ".$filterpeg." order by b.employees_code asc";
			
					$result = $connection->query($query_maspeg);
					$no=1;
					while($row = $result->fetch_assoc()) {
						$employees_id = $row['id'];
						$statuspeg = $row['status_peg'];
						/*
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
						else if($row['kdpeg'] == "PK"){
							$statuspeg = "PKM";
						}
						*/
						$begin = new DateTime($tgl_awal);
						$end   = new DateTime($tgl_akhir);

						for($i = $begin; $i <= $end; $i->modify('+1 day')){
							
							$tanggal = date('d-m-Y',strtotime($i->format("Y-m-d")));
							
							$tgl_absen = $i->format("Y-m-d");
							
							$query_absen ="SELECT presence_id,presence_date,time_in,time_out,picture_in,picture_out,present_id, latitude_longtitude_in,latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,
							IF (time_in>shift_time_in,'Telat',IF(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS STATUS, 
							TIMEDIFF(TIME(time_out),shift_time_out) AS selisih_out FROM presence a 
							WHERE a.presence_date = '$tgl_absen' AND a.employees_id = '$employees_id' ORDER BY presence_id ASC";	
							$result2 = $connection->query($query_absen);
							$dt = $result2->fetch_assoc();
							
							 // Status Absensi Jam Masuk
							if($dt['STATUS']=='Telat'){
							  $status_time_in ='<label class="label label-danger">Terlambat</label>';
							}
							  elseif ($dt['STATUS']=='Tepat Waktu') {
							  $status_time_in ='<label class="label label-info">'.$row_absen['STATUS'].'</label>';
							}
							else{
							  $status_time_in ='<label class="label label-danger">'.$row_absen['STATUS'].'</label>';
							}
							
							if ($result2->num_rows < 1){
								$status_time_in ='<label class="label label-warning">Tidak Absen</label>';
							}
							echo '
							<tr>
								<td>'.$no.'</td>
								<td>'.$tanggal.'</td>
								<td>'.$row['employees_code'].'</td>
								<td>'.$row['employees_name'].'</td>
								<td>'.$statuspeg.'</td>
								<td>'.$dt['time_in'].'</td>
								<td>'.$dt['selisih'].'</td>
								<td>'.$dt['time_out'].'</td>
								<td style="display:none">'.$dt['selisih_out'].'</td>
								<td>'.$status_time_in.'</td>
							</tr>';
							$no++;
						}
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
    ini_set('max_execution_time', '0');
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
				<th colspan='10'>LAPORAN ABSENSI</th>
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
				<th class="align-middle">No.Pegawai</th>
				<th class="align-middle">Nm.Pegawai</th>
				<th class="align-middle">Status Pegawai</th>
                <th class="align-middle text-center">Scan Masuk</th>
                <th class="align-middle text-center">Terlambat</th>
                <th class="align-middle text-center">Scan Pulang</th>
                <th class="align-middle text-center">Pulang Cepat</th>
                <th class="align-middle">Status</th>
            </tr>
        </thead>
        <tbody>';
		/*
		if($status_peg == "all"){
			$filterpeg = "";
		}
		else if($status_peg == "K"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'K-'";
		}
		else if($status_peg == "KK"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KK'";
		}
		else if($status_peg == "KPJ"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KP'";
		}
		else if($status_peg == "PSI"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PS'";
		}
		else if($status_peg == "PKM"){
			$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PK'";
		}*/
		
		if($status_peg == "all"){
			$filterpeg = "";
		}
		else{
			$filterpeg = "AND b.status_peg = '$status_peg'";
		}
		
		$query_maspeg = "select b.*,SUBSTR(b.employees_code,1,2) AS kdpeg from employees b where b.kd_bidang = '$kd_bidang' ".$filterpeg." order by b.employees_code asc";
			
		$result = $connection->query($query_maspeg);
		$no=1;
		while($row = $result->fetch_assoc()) {
			$employees_id = $row['id'];
			$statuspeg = $row['status_peg'];
			/*
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
			else if($row['kdpeg'] == "PK"){
				$statuspeg = "PKM";
			}*/
			
			$begin = new DateTime($tgl_awal);
			$end   = new DateTime($tgl_akhir);

			for($i = $begin; $i <= $end; $i->modify('+1 day')){
				
				$tanggal = date('d-m-Y',strtotime($i->format("Y-m-d")));
				
				$tgl_absen = $i->format("Y-m-d");
				
				$query_absen ="SELECT presence_id,presence_date,time_in,time_out,picture_in,picture_out,present_id, latitude_longtitude_in,latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,
				IF (time_in>shift_time_in,'Telat',IF(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS STATUS, 
				TIMEDIFF(TIME(time_out),shift_time_out) AS selisih_out FROM presence a 
				WHERE a.presence_date = '$tgl_absen' AND a.employees_id = '$employees_id' ORDER BY presence_id ASC";	
				$result2 = $connection->query($query_absen);
				$dt = $result2->fetch_assoc();
				
				 // Status Absensi Jam Masuk
				if($dt['STATUS']=='Telat'){
				  $status_time_in ='<label class="label label-danger">Terlambat</label>';
				}
				elseif ($dt['STATUS']=='Tepat Waktu') {
				  $status_time_in ='<label class="label label-info">'.$row_absen['STATUS'].'</label>';
				}
				else{
				  $status_time_in ='<label class="label label-danger">'.$row_absen['STATUS'].'</label>';
				}
				
				if ($result2->num_rows < 1){
					$status_time_in ='<label class="label label-warning">Tidak Absen</label>';
				}
				
				echo '
				<tr>
					<td>'.$no.'</td>
					<td>'.$tanggal.'</td>
					<td>'.$row['employees_code'].'</td>
					<td>'.$row['employees_name'].'</td>
					<td>'.$statuspeg.'</td>
					<td>'.$dt['time_in'].'</td>
					<td>'.$dt['selisih'].'</td>
					<td>'.$dt['time_out'].'</td>
					<td style="display:none">'.$dt['selisih_out'].'</td>
					<td>'.$status_time_in.'</td>
				</tr>';
				$no++;
			}
			
			
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
					<th colspan='9'>LAPORAN ABSENSI</th>
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
				<th class="align-middle">Bidang</th>
				<th class="align-middle">Tanggal</th>
				<th class="align-middle">No.Pegawai</th>
				<th class="align-middle">Nm.Pegawai</th>
				<th class="align-middle">Status Pegawai</th>
				<th class="align-middle text-center">Scan Masuk</th>
				<th class="align-middle text-center">Terlambat</th>
				<th class="align-middle text-center">Scan Pulang</th>
				<th class="align-middle text-center">Pulang Cepat</th>
				<th class="align-middle">Status</th>
			</tr>
		</thead>
		<tbody>';
		while($rowdt = $resultdt->fetch_assoc()) {
			$kdbidang = $rowdt['kd_bidang'];
			$nmbidang = $rowdt['nm_bidang'];
				/*
				if($status_peg == "all"){
					$filterpeg = "";
				}
				else if($status_peg == "K"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'K-'";
				}
				else if($status_peg == "KK"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KK'";
				}
				else if($status_peg == "KPJ"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'KP'";
				}
				else if($status_peg == "PSI"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PS'";
				}
				else if($status_peg == "PKM"){
					$filterpeg = "AND SUBSTR(b.employees_code,1,2) = 'PK'";
				}*/
				
				if($status_peg == "all"){
					$filterpeg = "";
				}
				else{
					$filterpeg = "AND b.status_peg = '$status_peg'";
				}
				
				$query_maspeg = "select b.*,SUBSTR(b.employees_code,1,2) AS kdpeg from employees b where b.kd_bidang = '$kdbidang' ".$filterpeg." order by b.employees_code asc";
			
				$result = $connection->query($query_maspeg);
				$no=1;
				while($row = $result->fetch_assoc()) {
					$employees_id = $row['id'];
					$statuspeg = $row['status_peg'];
					/*
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
					else if($row['kdpeg'] == "PK"){
						$statuspeg = "PKM";
					}
					*/
					$begin = new DateTime($tgl_awal);
					$end   = new DateTime($tgl_akhir);

					for($i = $begin; $i <= $end; $i->modify('+1 day')){
						
						$tanggal = date('d-m-Y',strtotime($i->format("Y-m-d")));
						
						$tgl_absen = $i->format("Y-m-d");
						
						$query_absen ="SELECT presence_id,presence_date,time_in,time_out,picture_in,picture_out,present_id, latitude_longtitude_in,latitude_longtitude_out,information,TIMEDIFF(TIME(time_in),shift_time_in) AS selisih,
						IF (time_in>shift_time_in,'Telat',IF(time_in='00:00:00','Tidak Masuk','Tepat Waktu')) AS STATUS, 
						TIMEDIFF(TIME(time_out),shift_time_out) AS selisih_out FROM presence a 
						WHERE a.presence_date = '$tgl_absen' AND a.employees_id = '$employees_id' ORDER BY presence_id ASC";	
						$result2 = $connection->query($query_absen);
						$dt = $result2->fetch_assoc();
						
						 // Status Absensi Jam Masuk
						if($dt['STATUS']=='Telat'){
						  $status_time_in ='<label class="label label-danger">Terlambat</label>';
						}
						  elseif ($dt['STATUS']=='Tepat Waktu') {
						  $status_time_in ='<label class="label label-info">'.$row_absen['STATUS'].'</label>';
						}
						else{
						  $status_time_in ='<label class="label label-danger">'.$row_absen['STATUS'].'</label>';
						}
						
						if ($result2->num_rows < 1){
							$status_time_in ='<label class="label label-warning">Tidak Absen</label>';
						}
						echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$nmbidang.'</td>
							<td>'.$tanggal.'</td>
							<td>'.$row['employees_code'].'</td>
							<td>'.$row['employees_name'].'</td>
							<td>'.$statuspeg.'</td>
							<td>'.$dt['time_in'].'</td>
							<td>'.$dt['selisih'].'</td>
							<td>'.$dt['time_out'].'</td>
							<td style="display:none">'.$dt['selisih_out'].'</td>
							<td>'.$status_time_in.'</td>
						</tr>';
						$no++;
					}
				}
				
		}
		echo'
		</tbody>
	  </table>';
	}
	
break;

}

}
