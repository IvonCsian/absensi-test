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
function acakangkahuruf($panjang){
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string = '';
        for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter{$pos};}
        return $string;
    }
$code   =  'SW'.acakangkahuruf(3).'/'.$year.'';

  $error = array();
  
  if (empty($_POST['name'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $name = mysqli_real_escape_string($connection, $_POST['name']);
  }

  if (empty($_POST['address'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $address= mysqli_real_escape_string($connection, $_POST['address']);
  }
  
  if (empty($_POST['koordinat_kantor'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $koordinat= mysqli_real_escape_string($connection, $_POST['koordinat_kantor']);
  }
  
  if (empty($_POST['radius'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $radius= mysqli_real_escape_string($connection, $_POST['radius']);
  }

  if (empty($error)) { 

    $add ="INSERT INTO  building (code,name,address,building_scanner,koordinat_kantor,radius) values('$code','$name','$address','','$koordinat',$radius)"; 
    if($connection->query($add) === false) { 
        die($connection->error.__LINE__); 
        echo'Data tidak berhasil disimpan!';
    } else{
        echo'success';
    }}
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

  if (empty($_POST['name'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $name= mysqli_real_escape_string($connection, $_POST['name']);
  }

  if (empty($_POST['address'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $address= mysqli_real_escape_string($connection, $_POST['address']);
  }
  
  if (empty($_POST['koordinat'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $koordinat= mysqli_real_escape_string($connection, $_POST['koordinat']);
  }
  
  if (empty($_POST['radius'])) {
      $error[] = 'tidak boleh kosong';
    } else {
      $radius= mysqli_real_escape_string($connection, $_POST['radius']);
  }

  if (empty($error)) { 
    $update="UPDATE building SET name='$name',
            address='$address',koordinat_kantor='$koordinat',radius='$radius' WHERE building_id='$id'"; 
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
  $query ="SELECT building.building_id,employees.building_id FROM building,employees WHERE building.building_id=employees.building_id AND employees.building_id='$id'";
  $result = $connection->query($query);
  if(!$result->num_rows > 0){
    $deleted  = "DELETE FROM building WHERE building_id='$id'";
    if($connection->query($deleted) === true) {
        echo'success';
      } else { 
        //tidak berhasil
        echo'Data tidak berhasil dihapus.!';
        die($connection->error.__LINE__);
       
    }
  }else{
      echo'Lokasi digunakan, Data tidak dapat dihapus.!';
    }
break;

}

}
