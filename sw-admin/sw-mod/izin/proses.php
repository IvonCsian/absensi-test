<?php
session_start();
if(empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])){
    header('location:../../login/');
 exit;}
else {
require_once'../../../sw-library/sw-config.php';
require_once'../../login/login_session.php';
include('../../../sw-library/sw-function.php');
$max_size = 2000000; //2MB
$salt = '$%DEf0&TTd#%dSuTyr47542"_-^@#&*!=QxR094{a911}+';

switch (@$_GET['action']){
/* ------------------------------
    Update status
---------------------------------*/
case 'update-status':
 $error = array();
   if (empty($_POST['id'])) {
      $error[] = 'ID tidak boleh kosong';
    } else {
      $id_izin = mysqli_real_escape_string($connection, $_POST['id']);
  }

  if (empty($_GET['status'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $status = mysqli_real_escape_string($connection, $_GET['status']);
  }

  if (empty($error)) { 
    $update="UPDATE izin SET status_izin='$status' WHERE id_izin='$id_izin'"; 
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

}

}
