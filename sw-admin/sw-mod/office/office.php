<?php 
if(empty($connection)){
  header('location:../../');
} else {
  $gotoprocess = "sw-mod/$mod/proses.php";
  include_once 'sw-mod/sw-panel.php';
echo'
  <div class="content-wrapper">';
    switch(@$_GET['op']){ 
    default:
echo'
<section class="content-header">
  <h1>Data<small> Lokasi kerja Pegawai</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Lokasi kerja Pegawai</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Lokasi Kerja Pegawai</b></h3>
          <div class="box-tools pull-right">';
          if($level_user==1){
            echo'
            <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Baru</button>';}
            else{
            echo'<button type="button" class="btn btn-success btn-flat access-failed"><i class="fa fa-plus"></i> Tambah Baru</button>';
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
				<th>No.Pegawai</th>
                <th>Nama</th>
				<th>Bidang</th>
                <th>Kantor</th>
                <th style="width:100px">Aksi</th>
              </tr>
              </thead>
              <tbody>';
              $query="SELECT a.*,b.employees_code,b.employees_name,d.nm_bidang,c.name AS buildingname FROM office_employees a 
				LEFT JOIN employees b ON a.employees_code = b.employees_code 
				LEFT JOIN building c ON a.building_id = c.building_id
				LEFT JOIN bidang d ON b.kd_bidang = d.kd_bidang
				ORDER BY a.id_office DESC";
              $result = $connection->query($query);
              if($result->num_rows > 0){
              $no=0;
             while ($row= $result->fetch_assoc()) {
                $no++;
                echo'
                <tr>
                  <td class="text-center">'.$no.'</td>
				  <td>'.$row['employees_code'].'</td>
                  <td>'.$row['employees_name'].'</td>
				  <td>'.$row['nm_bidang'].'</td>
                  <td>'.$row['buildingname'].'</td>
				  <td>
					<div class="btn-group">';
						if($level_user==1){
						echo'
						<a href="#modalEdit" class="btn btn-warning btn-xs enable-tooltip" title="Edit" data-toggle="modal"';?> onclick="getElementById('txtbuilding_id').value='<?PHP echo $row['building_id'];?>';getElementById('txtemployees_id').value='<?PHP echo $row['employees_name'];?>';getElementById('txtid').value='<?PHP echo $row['id_office'];?>';"><i class="fa fa-pencil-square-o"></i> Ubah</a>
						<?php echo'
						<buton data-id="'.epm_encode($row['id_office']).'" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';}
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
      <form class="form validate add-data">
      <div class="modal-body">
		<div class="form-group">
            <label>Pegawai</label>
            <select name="employees_id" id="employees_id" class="form-control select2">
				<option value="">--Pilih--</option>';
				 $query="SELECT employees_name,employees_code,id from employees order by id ASC";
				  $result = $connection->query($query);
				  while($row = $result->fetch_assoc()) { 
				  echo'<option value="'.$row['employees_code'].'">'.$row['employees_code'].' - '.$row['employees_name'].'</option>';
				  }echo'
			</select>
        </div>
		<div class="form-group">
            <label>Kantor</label>
            <select class="form-control" name="building_id" id="building_id" required="">
			  <option value="">- Pilih -</option>';
			  $query="SELECT * from building order by building_id ASC";
			  $result = $connection->query($query);
			  while($row = $result->fetch_assoc()) { 
			  echo'<option value="'.$row['building_id'].'">'.$row['name'].'</option>';
			  }echo'
		  </select>
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
      <form class="form update-data" method="post">
       <input type="hidden" name="id" id="txtid" required" value="" readonly>
      <div class="modal-body">
         
          <div class="form-group">
              <label>Pegawai</label>
              <input type="text" class="form-control" name="employees_name" id="txtemployees_id" readonly>
          </div>

          <div class="form-group">
              <label>Kantor</label>
              <select class="form-control" name="building_id" id="txtbuilding_id" required="">
				  <option value="">- Pilih -</option>';
				  $query="SELECT * from building order by building_id ASC";
				  $result = $connection->query($query);
				  while($row = $result->fetch_assoc()) { 
				  echo'<option value="'.$row['building_id'].'">'.$row['name'].'</option>';
				  }echo'
			  </select>
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