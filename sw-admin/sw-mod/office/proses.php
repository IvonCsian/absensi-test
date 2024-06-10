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

  if (empty($_POST['employees_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $employees_id= mysqli_real_escape_string($connection, $_POST['employees_id']);
  }


  if (empty($_POST['building_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $building_id = mysqli_real_escape_string($connection, $_POST['building_id']);
  }

  if (empty($error)) { 
		// -- cek data --
		$Query = "select * from office_employees where building_id = '$building_id' and employees_code = '$employees_id'";

		$result= $connection->query($Query) or die($connection->error.__LINE__);
		if(!$result ->num_rows >0){
			$add ="INSERT INTO  office_employees (employees_code,building_id) values('$employees_id','$building_id')"; 
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

  if (empty($_POST['building_id'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $building_id = mysqli_real_escape_string($connection, $_POST['building_id']);
  }


  if (empty($error)) { 
    $update="UPDATE office_employees SET
            building_id='$building_id'
           WHERE id_office='$id'"; 
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
  $query ="SELECT * from office_employees where id_office ='$id'";
  $result = $connection->query($query);
  if($result->num_rows > 0){
     $deleted  = "DELETE FROM office_employees WHERE id_office='$id'";
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
}

}
