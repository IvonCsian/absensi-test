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
  <h1>Data<small> Status Kerja</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Status Kerja</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Status Kerja</b></h3>
        </div>
          <div class="box-body">
          <div class="table-responsive">
          <table id="swdatatable" class="table table-bordered">
            <thead>
            <tr>
              <th style="width:20px" class="text-center">No</th>
              <th>Keterangan kerja</th>
              <th class="text-center">Status</th>
              <th style="width:100px">Aksi</th>
            </tr>
            </thead>
            <tbody>';
            $query="SELECT * FROM status_kerja order by id DESC";
            $result = $connection->query($query);
            if($result->num_rows > 0){
            $no=0;
           while ($row= $result->fetch_assoc()) {
              $no++;
			  
			  if($row['status'] == "aktif"){
				  $status = '<span class="badge bg-blue">Aktif</span>';
			  }
			  else{
				 $status = '<span class="badge bg-red">Non Aktif</span>'; 
			  }
              echo'
              <tr>
                <td class="text-center">'.$no.'</td>
                <td>'.$row['ket_kerja'].'</td>
                <td class="text-center">'.$status.'</td>
                <td>
                 <div class="btn-group">';
                  if($level_user==1){
                echo'
                <buton data-id="'.epm_encode($row['id']).'" class="btn btn-xs btn-danger delete" title="Update"><i class="fa fa-pencil"></i> Update</button>';}
                else {
                  echo'
                    <buton type="button" class="btn btn-xs btn-danger access-failed" title="Update"><i class="fa fa-pencil"></i> Update</button>';
                }echo'
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
</section>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Data</h4>
      </div>
      <form class="form update-jabatan" method="post">
       <input type="hidden" name="id" id="txtid" required" value="" readonly>
      <div class="modal-body">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="position_name" id="txtnama" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Simpan</button>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
      </div>
    </form>
    </div>
  </div>
</div>';
break;
}?>

</div>
<?php }?>