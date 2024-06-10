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
  if (empty($_POST['kd_bidang'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $kd_bidang= mysqli_real_escape_string($connection, $_POST['kd_bidang']);
  }
  if (empty($_POST['nm_bidang'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $nm_bidang= mysqli_real_escape_string($connection, $_POST['nm_bidang']);
  }

  if (empty($error)) { 
	$cekdt = "select * from bidang where kd_bidang = '$kd_bidang'";
	$result = $connection->query($cekdt);
	if($result->num_rows == 0){
		$add ="INSERT INTO bidang (kd_bidang,nm_bidang) values('$kd_bidang','$nm_bidang')"; 
		if($connection->query($add) === false) { 
			die($connection->error.__LINE__); 
			echo'Data tidak berhasil disimpan!';
		} else{
			echo'success';
		}
	}
	else{
		echo'Kode Bidang sudah ada..!';
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

  if (empty($_POST['bidangkode'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $bidangkode= mysqli_real_escape_string($connection, $_POST['bidangkode']);
  }
  if (empty($_POST['bidangname'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $bidangname= mysqli_real_escape_string($connection, $_POST['bidangname']);
  }

  if (empty($error)) { 
    $update="UPDATE bidang SET nm_bidang='$bidangname',kd_bidang='$bidangkode' WHERE id_bidang='$id'"; 
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
  $query ="SELECT b.employees_code FROM bidang a INNER JOIN employees b ON a.kd_bidang = b.kd_bidang WHERE a.id_bidang = '$id'";
  $result = $connection->query($query);
  if($result->num_rows == 0){
    $deleted  = "DELETE FROM bidang WHERE id_bidang='$id'";
      if($connection->query($deleted) === true) {
          echo'success';
        } else { 
          //tidak berhasil
          echo'Data tidak berhasil dihapus.!';
          die($connection->error.__LINE__);
    }
  }else{
      echo'Bidang digunakan, Data tidak dapat dihapus.!';
  }



break;

}

}
