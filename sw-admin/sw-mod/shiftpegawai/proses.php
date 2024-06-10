<?php
session_start();
if(empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])){
    header('location:../../login/');
 exit;}
else {
require_once'../../../sw-library/sw-config.php';
require_once'../../login/login_session.php';
require_once'../../phpexcelreader/excel_reader2.php';
include('../../../sw-library/sw-function.php');


switch (@$_GET['action']){

case 'add':
  $error = array();
  
  if (empty($_POST['tanggal'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tanggal= date('Y-m-d',strtotime($_POST['tanggal']));
  }

  if (empty($_POST['employees_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_id= mysqli_real_escape_string($connection, $_POST['employees_id']);
  }


  if (empty($_POST['shift_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $shift_id = mysqli_real_escape_string($connection, $_POST['shift_id']);
  }

  if (empty($error)) { 
		// -- cek data --
		$Query = "select * from employees_shift where tanggal = '$tanggal' and employees_id = '$employees_id'";

		$result= $connection->query($Query) or die($connection->error.__LINE__);
		if(!$result ->num_rows >0){
			$add ="INSERT INTO  employees_shift (tanggal,employees_id,shift_id) values('$tanggal','$employees_id','$shift_id')"; 
			if($connection->query($add) === false) { 
				die($connection->error.__LINE__); 
				echo'Data tidak berhasil disimpan!';
			} else{
				echo'success';
			}
		}
		else{
			echo'Data sudah ada!';
		}
	}
    else{           
        echo'Bidang inputan masih ada yang kosong..!';
    }
break;

/* ------------------------------
    Update
---------------------------------*/
case 'update':
 $error = array();
   if (empty($_POST['id'])) {
      $error[] = 'ID tidak boleh kosong';
    } else {
      $id = mysqli_real_escape_string($connection, $_POST['id']);
  }

   if (empty($_POST['tanggal'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $tanggal= date('Y-m-d',strtotime($_POST['tanggal']));
  }

  if (empty($_POST['shift_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $shift_id = mysqli_real_escape_string($connection, $_POST['shift_id']);
  }


  if (empty($error)) { 
    $update="UPDATE employees_shift SET tanggal='$tanggal',
            shift_id='$shift_id'
           WHERE id_shift='$id'"; 
    if($connection->query($update) === false) { 
        die($connection->error.__LINE__); 
        echo'Data tidak berhasil disimpan!';
    } else{
        echo'success';
    }}
    else{           
        echo'Bidang inputan tidak boleh ada yang kosong..!';
    }

break;
/* --------------- Delete ------------*/
case 'delete':
  $id       = mysqli_real_escape_string($connection,epm_decode($_POST['id']));
  $query ="SELECT * from employees_shift where id_shift ='$id'";
  $result = $connection->query($query);
  if($result->num_rows > 0){
     $deleted  = "DELETE FROM employees_shift WHERE id_shift='$id'";
        if($connection->query($deleted) === true) {
            echo'success';
          } else { 
            //tidak berhasil
            echo'Data tidak berhasil dihapus.!';
            die($connection->error.__LINE__);
		  }
    }
  else{
      echo'Data gagal dihapus.!';
  }


break;

case 'viewdt':
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	
	
	echo '<table id="table_shift" class="table table-bordered" width="100%">
		<thead>
			<tr>
				<th style="width:20px" class="text-center">No</th>
				<th>Tanggal</th>
				<th>No.Pegawai</th>
                <th>Nama</th>
				<th>Bidang</th>
                <th>Shift</th>
                <th style="width:100px">Aksi</th>
              </tr>
		</thead>
		<tbody>';
		 $query="SELECT a.*,b.employees_code,b.employees_name,c.shift_name,d.nm_bidang FROM employees_shift a 
		  left join employees b on a.employees_id = b.id 
		  left join shift c on a.shift_id = c.shift_id
		  LEFT JOIN bidang d ON b.kd_bidang = d.kd_bidang
		  where month(a.tanggal) = '$bulan' and year(a.tanggal) = '$tahun'
		  order by a.tanggal DESC";
		  $result = $connection->query($query);
		  if($result->num_rows > 0){
		  $no=0;
		 while ($row= $result->fetch_assoc()) {
			$no++;
			echo'
			<tr>
			  <td class="text-center">'.$no.'</td>
			  <td>'.tgl_ind($row['tanggal']).'</td>
			  <td>'.$row['employees_code'].'</td>
			  <td>'.$row['employees_name'].'</td>
			  <td>'.$row['nm_bidang'].'</td>
			  <td>'.$row['shift_name'].'</td>
			  <td>
				<div class="btn-group">';
					if($level_user==1){
					echo'
					<a href="#modalEdit" class="btn btn-warning btn-xs enable-tooltip" title="Edit" data-toggle="modal"';?> onclick="getElementById('txtshift_id').value='<?PHP echo $row['shift_id'];?>';getElementById('txttanggal').value='<?PHP echo date('d-m-Y',strtotime($row['tanggal']));?>';getElementById('txtemployees_id').value='<?PHP echo $row['employees_name'];?>';getElementById('txtid').value='<?PHP echo $row['id_shift'];?>';"><i class="fa fa-pencil-square-o"></i> Ubah</a>
					<?php echo'
					<buton data-id="'.epm_encode($row['id_shift']).'" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';}
				  else{
				echo'
					  <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</button>
					  <buton type="button" class="btn btn-xs btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';
				  }
				  echo'
				  </div>
			  </td>
			</tr>';}}

        echo "</tbody>
		</table>
		<script>
			$('#table_shift').dataTable({
				'iDisplayLength': 20,
				'aLengthMenu': [[20, 30, 50, -1], [20, 30, 50, 'All']],
			});
		</script>";
break;

case 'upload':
	$target = basename($_FILES['filepegawai']['name']) ;
	
	$str = explode(".",$_FILES['filepegawai']['name']);
	$extention = $str[1];
	
	if($extention == 'xls'){
		move_uploaded_file($_FILES['filepegawai']['tmp_name'], $target);
	 
		// beri permisi agar file xls dapat di baca
		chmod($_FILES['filepegawai']['name'],0777);
		 
		// mengambil isi file xls
		$data = new Spreadsheet_Excel_Reader($_FILES['filepegawai']['name'],false);
		// menghitung jumlah baris data yang ada
		$jumlah_baris = $data->rowcount($sheet_index=0);
		
		// jumlah default data yang berhasil di import
		$berhasil = 0;
		for ($i=2; $i<=$jumlah_baris; $i++){
			// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
			$tanggal_shift     = $data->val($i, 1);
			$employees_code   = $data->val($i, 2);
			$shift_name  = $data->val($i, 4);
			
			// --- pegawai ---
			$QcekPegawai = "select * from employees where employees_code = '$employees_code'";
			$result = $connection->query($QcekPegawai);
			$row = $result->fetch_assoc();
			$employees_id = $row['id'];
			
			// ---- shift id ---
			$QcekShift = "select * from shift where shift_name = '$shift_name'";
			$result2 = $connection->query($QcekShift);
			$row = $result2->fetch_assoc();
			$shift_id = $row['shift_id'];
			
			// --- format tanggal ---
			$tanggal = date('Y-m-d',strtotime($tanggal_shift));
			
			// --- hapus data ---
			$Qhapus = "delete from employees_shift where tanggal = '$tanggal' and employees_id = '$employees_id'";
			$connection->query($Qhapus);	
			
			// --- insert data ---
			$add ="INSERT INTO  employees_shift (tanggal,employees_id,shift_id) values('$tanggal','$employees_id','$shift_id')"; 
			$connection->query($add);		
			
			$berhasil++;
		}
		 
		// hapus kembali file .xls yang di upload tadi
		unlink($_FILES['filepegawai']['name']);
		
		echo 1;
	}
	else{
		echo 2;
	}
	
break;

case 'exceltemplate':
	
	$file = "template_shift.xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	
	echo'
	<table border="1">
	<thead>
		<tr>
			<th class="align-middle">Tanggal</th>
			<th class="align-middle">No.Pegawai</th>
			<th class="align-middle">Nm.Pegawai</th>
			<th class="align-middle">Nama Shift</th>
		</tr>
	</thead>
	</table>';
	
break;
}

}
