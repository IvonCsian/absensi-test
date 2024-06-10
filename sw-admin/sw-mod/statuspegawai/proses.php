<?php
session_start();
if(empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])){
    header('location:../../login/');
 exit;}
else {
require_once'../../../sw-library/sw-config.php';
require_once'../../login/login_session.php';
include('../../../sw-library/sw-function.php');

switch (@$_GET['action']){
case 'add':
  $error = array();
  if (empty($_POST['kd_peg'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $kd_peg= mysqli_real_escape_string($connection, $_POST['kd_peg']);
  }
  if (empty($_POST['status_peg'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $status_peg= mysqli_real_escape_string($connection, $_POST['status_peg']);
  }

  if (empty($error)) { 
	$cekdt = "select * from bidang where kode_peg = '$kd_peg'";
	$result = $connection->query($cekdt);
	if($result->num_rows == 0){
		$add ="INSERT INTO status_pegawai (kode_peg,status_peg) values('$kd_peg','$status_peg')"; 
		if($connection->query($add) === false) { 
			die($connection->error.__LINE__); 
			echo'Data tidak berhasil disimpan!';
		} else{
			echo'success';
		}
	}
	else{
		echo'Kode Pegawai sudah ada..!';
	}
  }
  else{           
		echo'Bidang inputan tidak boleh ada yang kosong..!';
  }
break;

/* --------------------------------
    Update
---------------------------------*/
case 'update':
 $error = array();
   if (empty($_POST['id'])) {
      $error[] = 'ID tidak boleh kosong';
    } else {
      $id = mysqli_real_escape_string($connection, $_POST['id']);
  }

  if (empty($_POST['pegkode'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $pegkode= mysqli_real_escape_string($connection, $_POST['pegkode']);
  }
  if (empty($_POST['statusname'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $statusname= mysqli_real_escape_string($connection, $_POST['statusname']);
  }

  if (empty($error)) { 
    $update="UPDATE status_pegawai SET status_peg='$statusname',kode_peg='$pegkode' WHERE id_status='$id'"; 
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
  $query ="SELECT b.employees_code FROM status_pegawai a INNER JOIN employees b ON a.status_peg = b.status_peg WHERE a.id_status = '$id'";
  $result = $connection->query($query);
  if($result->num_rows == 0){
    $deleted  = "DELETE FROM status_pegawai WHERE id_status='$id'";
      if($connection->query($deleted) === true) {
          echo'success';
        } else { 
          //tidak berhasil
          echo'Data tidak berhasil dihapus.!';
          die($connection->error.__LINE__);
    }
  }else{
      echo'Status Pegawai digunakan, Data tidak dapat dihapus.!';
  }



break;

}

}
