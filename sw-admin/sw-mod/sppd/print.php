<?php session_start();
    require_once'../../../sw-library/sw-config.php'; 
    require_once'../../../sw-library/sw-function.php';
    include_once'../../../sw-library/vendor/autoload.php';
if(empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])){
    //Kondisi tidak login
   header('location:../login/');
}

else{
  //kondisi login
switch (@$_GET['action']){

case 'printspd':
if (empty($_GET['id'])) {
      $error[] = 'ID tidak boleh kosong';
    } else {
      $id = mysqli_real_escape_string($connection,epm_decode($_GET['id']));
  }
if (empty($error)) {
$query="SELECT employees.employees_code,employees.employees_name,position.position_name,sppd.* 
FROM sppd 
LEFT JOIN employees ON employees.id = sppd.employees_id 
LEFT JOIN `position` ON employees.position_id = position.position_id
WHERE sppd.is_del = 0 AND sppd.id_sppd = '$id'";

$result = $connection->query($query);
if($result->num_rows > 0){
$row    = $result->fetch_assoc();
echo'
<!DOCTYPE html>
<html>
<head>
    <title>SURAT PERJALANAN DINAS '.$row['employees_name'].'</title>
    <style>
    body{font-family:Arial,Helvetica,sans-serif}.container_box{position:relative}.container_box .row h3{line-height:25px;font-size:20px;margin:0px 0 10px;text-transform:uppercase}.container_box .text-center{text-align:center}.container_box .content_box{position:relative;margin-top:50px;}.container_box .content_box .des_info{margin:20px 0;text-align:right}.container_box h3{font-size:30px}table.customTable{width:100%;background-color:#fff;border-collapse:collapse;border-width:0px;border-color:#b3b3b3;border-style:solid;color:#000}table.customTable td,table.customTable th{border-width:0px;border-color:#b3b3b3;border-style:solid;padding:10px;text-align:left}table.customTable thead{background-color:#f6f3f8}.text-center{text-align:center}
    .label {display: inline;padding: .2em .6em .3em;font-size: 75%;font-weight: 700;line-height: 1;color: #fff;text-align: center;white-space: nowrap; vertical-align: baseline;border-radius: .25em;}
    .label-success{background-color: #00a65a !important;}.label-warning {background-color: #f0ad4e;}.label-info {background-color: #5bc0de;}.label-danger{background-color: #dd4b39 !important;}
    p{line-height:20px;padding:0px;margin: 5px;}.pull-right{float:right}
    .name-ttd{
      font-weight:bold;
      text-align:center;
      text-decoration: underline;
      margin-top:70px;
      text-transform:uppercase
    }
    hr{
      border-top: 1px solid black;
    }

    @media print {
      a[href]:after { content: none !important; }
      @page { margin: 0; }
      body  { margin: 1.6cm; }
    }
        </style>
  <script>
     window.onafterprint = window.close;
         window.print();
  </script>
</head>
<body>

<section class="container_box">
      <div class="row">
          <h3 class="text-center">SURAT PERINTAH PERJALAN DINAS<br>'.$site_company.'</h3>
          <p class="text-center">'.$site_address.'</p>
          <hr>
        <div class="content_box">

          <p style="margin:20px 0px 10px 0px;">Koperasi Karyawan Keluarga Petrokimia Gresik<br>
          menugaskan kepada:<p>
          <table class="table customTable">
            <tbody>
			  <tr>
                <td width="200">No.Bukti</td>
                <td>: '.$row['no_bukti'].'</td>
              </tr>
              <tr>
                <td width="200">Nama</td>
                <td>: '.$row['employees_name'].'</td>
              </tr>
              <tr>
                <td>Jabatan</td>
                <td>: '.$row['position_name'].'</td>
              </tr>

              <tr>
                <td>Tanggal SPPD</td>
                <td>: '.tgl_ind($row['tgl_awal']).' sampai '.tgl_ind($row['tgl_akhir']).'</td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td>: '.strip_tags($row['keterangan']).'</td>
              </tr>

            </tbody>
          </table>

          <p style="margin-top:50px">Tanggal '.tgl_indo($date).'</p>
          <center>
            <table class="table customTable" style="margin-top:10px;">
              <tbody>
                <tr>
                  <td class="text-center">Pemohon<p class="name-ttd">'.$row['employees_name'].'</p></td>
                  <td class="text-center">Menyetujui<p class="name-ttd">'.$site_manager.'</p></td>
                  <td class="text-center">Mengetahui<p class="name-ttd">'.$site_director.'</p></td>
                </tr>
              </tbody>
            </table>
          </center>

        </div>
</section>';
}else{
  echo'Data tidak ditemukan';
}
}

break;
  }
}?>