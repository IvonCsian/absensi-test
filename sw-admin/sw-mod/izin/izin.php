<?php 
if(empty($connection)){
  header('location:../../');
} else {
  include_once 'sw-mod/sw-panel.php';
echo'
  <div class="content-wrapper">';
switch(@$_GET['op']){ 
    default:
echo'
<section class="content-header">
  <h1>Data<small> Permohonan Izin Pegawai</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Permohonan Izin Pegawai</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Permohonan Izin Pegawai</b></h3>
        </div>
<div class="box-body">
<div class="table-responsive">
<table id="swdatatable" class="table table-bordered">
  <thead>
  <tr>
    <th style="width: 10px">No</th>
	<th>No.Bukti</th>
	<th>No.Pegawai</th>
    <th>Nama</th>
    <th>Tgl.Awal</th>
    <th>Tgl.akhir</th>
    <th>Keterangan</th>
    <th>Status</th>
    <th style="width:150px" class="text-center">Aksi</th>
  </tr>
  </thead>
  <tbody>';
  $query="SELECT employees.employees_code,employees.employees_name,izin.* FROM izin LEFT JOIN employees ON employees.id = izin.employees_id WHERE izin.is_del = 0 ORDER BY izin.id_izin DESC ";
  $result = $connection->query($query);
  if($result->num_rows > 0){
  $no=0;
 while ($row= $result->fetch_assoc()) {
    if($row['status_izin'] =='2'){
      $status ='<span class="text-primary">Disetujui</span>';
    }elseif ($row['status_izin'] =='3') {
      $status='<span class="text-danger">Tidak Disetujui</span>';
    }else{
      $status='<span class="text-muted">Blm.Approve</span>';
    }
    $no++;
    echo'
    <tr>
      <td class="text-center">'.$no.'</td>
	  <td>'.$row['no_bukti'].'</td>
	  <td>'.$row['employees_code'].'</td>
      <td>'.$row['employees_name'].'</td>
      <td>'.tgl_ind($row['tgl_awal']).'</td>
      <td>'.tgl_ind($row['tgl_akhir']).'</td>
      <td>'.strip_tags($row['keterangan']).'</td>
      <td>'.$status.'</td>
      <td class="text-center">
        <div class="btn-group">';
        if($level_user==1){
          echo'
          <div class="btn-group">
            <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Proses
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:void(0);" data-id="'.$row['id_izin'].'" data-status="2" class="update-status">Setujui</a></li>
              <li><a href="javascript:void(0);" data-id="'.$row['id_izin'].'" data-status="3" class="update-status">Tidak disetujui</a></li>
            </ul>
          </div>
          <a href="cuty/print?action=printizin&id='.epm_encode($row['id_izin']).'" target="_blank"  class="btn btn-xs btn-danger delete" title="Print"><i class="fa fa-print" aria-hidden="true"></i> Print</a>';
		  }
        else{
        echo'
          <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</button>
          <buton type="button" class="btn btn-xs btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';
        }
        echo'
        </div>

      </td>
    </tr>';}}
  echo'
  </tbody>
  </table>
    </div>
      </div>
    </div>
  </div> 
</section>';
break;

}?>

</div>
<?php }?>