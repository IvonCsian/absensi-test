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
  <h1>Data<small> Status Pegawai</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Status Pegawai</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Status Pegawai</b></h3>
          <div class="box-tools pull-right">';
          if($level_user==1){
            echo'
            <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Baru</button>';}
          else{
            echo'
            <button type="button" class="btn btn-success btn-flat access-failed"><i class="fa fa-plus"></i> Tambah Baru</button>';
          }
          echo'
          </div>
        </div>
          <div class="box-body">
          <div class="table-responsive">
          <table id="swdatatable" class="table table-bordered">
            <thead>
            <tr>
              <th style="width:20px" class="text-center">No</th>
              <th>Kode Status</th>
              <th class="text-center">Status Pegawai</th>
              <th style="width:100px">Aksi</th>
            </tr>
            </thead>
            <tbody>';
            $query="SELECT * FROM status_pegawai order by id_status DESC";
            $result = $connection->query($query);
            if($result->num_rows > 0){
            $no=0;
           while ($row= $result->fetch_assoc()) {
              $no++;
              echo'
              <tr>
                <td class="text-center">'.$no.'</td>
                <td>'.$row['kode_peg'].'</td>
                <td>'.$row['status_peg'].'</td>
                <td>
                  <div class="btn-group">';
                  if($level_user==1){
                    echo'
                    <a href="#modalEdit" class="btn btn-warning btn-xs enable-tooltip" title="Edit" data-toggle="modal"';?> onclick="getElementById('txtid').value='<?PHP echo $row['id_status'];?>';getElementById('txtnama').value='<?PHP echo $row['status_peg'];?>';getElementById('txtkode').value='<?PHP echo $row['kode_peg'];?>'"><i class="fa fa-pencil-square-o"></i> Ubah</a>
                <?php echo'
                <buton data-id="'.epm_encode($row['id_status']).'" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';}
                else {
                  echo'
                    <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</button>
                    <buton type="button" class="btn btn-xs btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';
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

<!-- Add -->
<div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Baru</h4>
      </div>
      <form id="validate" class="form add-status">
      <div class="modal-body">
		<div class="form-group">
            <label>Kode Status</label>
            <input type="text" class="form-control" name="kd_peg" id="kode" required>
        </div>
        <div class="form-group">
            <label>Status Pegawai</label>
            <input type="text" class="form-control" name="status_peg" id="nama" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Simpan</button>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Data</h4>
      </div>
      <form class="form update-status" method="post">
       <input type="hidden" name="id" id="txtid" required" value="" readonly>
      <div class="modal-body">
		 <div class="form-group">
            <label>Kode Pegawai</label>
            <input type="text" class="form-control" name="pegkode" id="txtkode" required>
        </div>
        <div class="form-group">
            <label>Status Pegawai</label>
            <input type="text" class="form-control" name="statusname" id="txtnama" required>
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