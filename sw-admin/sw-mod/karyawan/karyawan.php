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
  <h1>Data<small> Karyawan</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Karyawan</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Karyawan</b></h3>
          <div class="box-tools pull-right">';
          if($level_user==1){
            echo'
            <a href="'.$mod.'&op=add" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Tambah Baru</a>';}
          else{
            echo'<button type="button" class="btn btn-success btn-flat access-failed"><i class="fa fa-plus"></i> Tambah Baru</button>';
          }echo'
          </div>
        </div>
    <div class="box-body">
      <div class="table-responsive">
          <table id="swdatatable" class="table table-bordered">
            <thead>
            <tr>
              <th style="width: 10px">No</th>
              <th>NIK</th>
              <th>Nama</th>
              <th>Email</th>
			  <th>Bidang</th>
              <th>Jabatan</th>
			  <th>Status Pegawai</th>
              <th>Shift</th>
              <th>Lokasi</th>
			  <th>Alamat</th>
			  <th>Koordinat Rumah</th>
			  <th>No.Handphone</th>
			  <th>Kondisi Khusus</th>
              <th style="width:150px" class="text-right">Aksi</th>
            </tr>
            </thead>
            <tbody>';
            $query="SELECT a.*,b.position_name,c.shift_name,d.name,e.nm_bidang FROM employees a 
			INNER JOIN `position` b ON a.position_id = b.position_id
			INNER JOIN shift c ON a.shift_id = c.shift_id
			INNER JOIN building d ON a.building_id = d.building_id
			LEFT JOIN bidang e ON a.kd_bidang = e.kd_bidang
			ORDER BY a.id DESC";
            $result = $connection->query($query);
            if($result->num_rows > 0){
            $no=0;
           while ($row= $result->fetch_assoc()) {
              $no++;
			  if($row['flag_khusus'] == 1){
				$khusus ='<label class="label label-info">V</label>';  
			  }
			  else{
				$khusus ='<label class="label label-danger">X</label>';  
			  }
              echo'
              <tr>
                <td class="text-center">'.$no.'</td>
                <td>'.$row['employees_code'].'</td>
                <td>'.$row['employees_name'].'</td>
                <td>'.$row['employees_email'].'</td>
				<td>'.$row['nm_bidang'].'</td>
                <td>'.$row['position_name'].'</td>
				<td>'.$row['status_peg'].'</td>
                <td>'.$row['shift_name'].'</td>
                <td>'.$row['name'].'</td>
				<td>'.$row['address'].'</td>
				<td>'.$row['home_coordinate'].'</td>
				<td>'.$row['phone'].'</td>
				<td>'.$khusus.'</td>
                <td class="text-right">
                  <div class="btn-group">';
                  if($level_user==1){
                    echo'
                    <a href="./'.$mod.'&op=edit&id='.epm_encode($row['id']).'" class="btn btn-warning btn-xs enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</a>
                    <buton data-id="'.epm_encode($row['id']).'" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';}
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


case 'add':
echo'
<section class="content-header">
  <h1>Tambah Data<small> Karyawan</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li><a href="./karyawan"> Data Karyawan</a></li>
      <li class="active">Tambah Karyawan</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Tambah Data Karyawan</b></h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal validate add-karyawan">
              <div class="box-body">

                <div class="form-group">
                  <label class="col-sm-2 control-label">NIK</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_code" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_name" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_email" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" name="employees_password" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Bidang</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="kd_bidang" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT * from bidang order by kd_bidang ASC";
                      $result = $connection->query($query);
                      while($row = $result->fetch_assoc()) { 
                      echo'<option value="'.$row['kd_bidang'].'">'.$row['nm_bidang'].'</option>';
                      }echo'
                  </select>
                  </div>
                </div>
				
                <div class="form-group">
                  <label class="col-sm-2 control-label">Jabatan</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="position_id" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT * from position order by position_name ASC";
                      $result = $connection->query($query);
                      while($row = $result->fetch_assoc()) { 
                      echo'<option value="'.$row['position_id'].'">'.$row['position_name'].'</option>';
                      }echo'
                  </select>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Status Pegawai</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="status_peg" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT * from status_pegawai order by id_status ASC";
                      $result = $connection->query($query);
                      while($row = $result->fetch_assoc()) { 
                      echo'<option value="'.$row['status_peg'].'">'.$row['status_peg'].'</option>';
                      }echo'
                  </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Shift</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="shift_id" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT shift_id,shift_name from shift order by shift_name ASC";
                      $result = $connection->query($query);
                      while($row = $result->fetch_assoc()) { 
                      echo'<option value="'.$row['shift_id'].'">'.$row['shift_name'].'</option>';
                      }echo'
                  </select>
                  </div>
                </div>


                <div class="form-group">
                  <label class="col-sm-2 control-label">Kantor</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="building_id" id="building" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT building_id,name,address from building order by name ASC";
                      $result = $connection->query($query);
                      while($row = $result->fetch_assoc()) { 
                      echo'<option value="'.$row['building_id'].'">'.$row['name'].'</option>';
                      }echo'
                  </select>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Koordinat Rumah</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="home_coordinate" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">No.Handphone</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Konsdisi Khusus</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="flag_khusus" id="flag_khusus">
                      <option value="0">- Pilih -</option>
					  <option value="0">Tidak</option>
					  <option value="1">Ya</option>
					</select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Foto</label>
                  <div class="col-sm-6">
                    <img width="80" class="preview" src="./sw-assets/img/avatar.jpg"><br><br>
                    <input type="file" id="imgInp" class="btn btn-default" id="file" name="photo" required="" accept="image/jpeg, image/jpg, image/gif" capture>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-2"></div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                <a class="btn btn-danger" href="./'.$mod.'"><i class="fa fa-remove"></i> Batal</a>
              </div>
              <!-- /.box-footer -->
            </form>
        
      </div>
    </div>
  </div> 
</section>';
break;

case 'edit':
echo'
<section class="content-header">
  <h1>Edit Data<small> Karyawan</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li><a href="./karyawan"> Data Karyawan</a></li>
      <li class="active">Edit Karyawan</li>
    </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Profil</a></li>
            <li><a href="#tab_2" data-toggle="tab">Ubah Password</a></li>
          </ul>
        </div>

      <div class="box-body">';
      if(!empty($_GET['id'])){
      $id     =  mysqli_real_escape_string($connection,epm_decode($_GET['id'])); 
      $query  ="SELECT * from employees WHERE id='$id'";
      $result = $connection->query($query);
      if($result->num_rows > 0){
      $row  = $result->fetch_assoc();
      echo'
      <div class="nav-tabs-custom">
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">

            <form class="form-horizontal validate update-karyawan">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">NIK</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_code" value="'.$row['employees_code'].'" required>
                    <input type="hidden"  name="id" value="'.$row['id'].'" readonly required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_name" value="'.$row['employees_name'].'" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Bidang</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="bidang_id" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT * from bidang order by nm_bidang ASC";
                      $result = $connection->query($query);
                      while($rowa = $result->fetch_assoc()) { 
                      if($rowa['kd_bidang'] == $row['kd_bidang']){
                        echo'<option value="'.$rowa['kd_bidang'].'" selected>'.$rowa['nm_bidang'].'</option>';
                      }else{
                        echo'<option value="'.$rowa['kd_bidang'].'">'.$rowa['nm_bidang'].'</option>';
                      }
                      }echo'
                  </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Jabatan</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="position_id" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT * from position order by position_name ASC";
                      $result = $connection->query($query);
                      while($rowa = $result->fetch_assoc()) { 
                      if($rowa['position_id'] == $row['position_id']){
                        echo'<option value="'.$rowa['position_id'].'" selected>'.$rowa['position_name'].'</option>';
                      }else{
                        echo'<option value="'.$rowa['position_id'].'">'.$rowa['position_name'].'</option>';
                      }
                      }echo'
                  </select>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Status Pegawai</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="status_peg" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT * from status_pegawai order by id_status ASC";
                      $result = $connection->query($query);
                      while($rowa = $result->fetch_assoc()) { 
                      if($rowa['status_peg'] == $row['status_peg']){
                        echo'<option value="'.$rowa['status_peg'].'" selected>'.$rowa['status_peg'].'</option>';
                      }else{
                        echo'<option value="'.$rowa['status_peg'].'">'.$rowa['status_peg'].'</option>';
                      }
                      }echo'
                  </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Shift</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="shift_id" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT shift_id,shift_name from shift order by shift_name ASC";
                      $result = $connection->query($query);
                      while($rowa = $result->fetch_assoc()) {
                      if($rowa['shift_id'] == $row['shift_id']){ 
                        echo'<option value="'.$rowa['shift_id'].'" selected>'.$rowa['shift_name'].'</option>';
                      }else{
                        echo'<option value="'.$rowa['shift_id'].'">'.$rowa['shift_name'].'</option>';
                      }
                      }echo'
                  </select>
                  </div>
                </div>


                <div class="form-group">
                  <label class="col-sm-2 control-label">Penempatan</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="building_id" id="building" required="">
                      <option value="">- Pilih -</option>';
                      $query="SELECT building_id,name,address from building order by name ASC";
                      $result = $connection->query($query);
                      while($rowa = $result->fetch_assoc()) { 
                      if($rowa['building_id'] == $row['building_id']){ 
                        echo'<option value="'.$rowa['building_id'].'" selected>'.$rowa['name'].'</option>';
                      }else{
                        echo'<option value="'.$rowa['building_id'].'">'.$rowa['name'].'</option>';
                      }
                      }echo'
                  </select>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="'.$row['address'].'" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Koordinat Rumah</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="home_coordinate" value="'.$row['home_coordinate'].'" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">No.Handphone</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="'.$row['phone'].'" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Kondisi Khusus</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="flag_khusus">
                      <option value="0">- Pilih -</option>';
					  if($row['flag_khusus'] == 1){
						echo'<option value="0">Tidak</option>'; 
						echo'<option value="'.$row['flag_khusus'].'" selected>Ya</option>';  
					  }
					  else if($row['flag_khusus'] == 0){
						echo'<option value="'.$row['flag_khusus'].'" selected>Tidak</option>';  
						echo'<option value="1">Ya</option>';    
					  }
                  echo '</select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Foto</label>
                  <div class="col-sm-6">
                    <div class="upload-media">';
                     if($row['photo'] == NULL){
                      echo'<img width="80" class="preview" width="80" src="../sw-assets/img/avatar.jpg">';}
                    else{
                      echo'<img width="80" class="preview" width="80" src="../sw-content/karyawan/'.$row['photo'].'">';
                    }echo'
                    </div>
                    <input type="file" id="imgInp" class="btn btn-default" id="file" name="photo" accept="image/jpeg, image/jpg, image/gif" capture>
                    <small>Kosongan jika tidak ingin mengubah</small>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-2"></div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                <a class="btn btn-danger" href="./'.$mod.'"><i class="fa fa-remove"></i> Batal</a>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>

          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_2">
            <form class="form-horizontal validate update-password">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_email" value="'.$row['employees_email'].'" readonly required>
                    <input type="hidden"  name="id" value="'.$row['id'].'" readonly required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="password" name="employees_password" required>
					<input type="checkbox" onclick="myFunction()">Show Password 
                  </div>
                </div>

              </div>
              
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-sm-2"></div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                <a class="btn btn-danger" href="./'.$mod.'"><i class="fa fa-remove"></i> Batal</a>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        <!-- /.tab-content -->
      </div>
      <!-- nav-tabs-custom -->';
      }else{
         echo'<section class="content">
            <div class="error-page">
              <h2 class="headline text-yellow"> 404</h2>
              <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                <p>
                Saat ini data yang Anda cari tidak ditemukan<br>
                <a class="btn btn-primary" href="./">return to dashboard</a>
                </p>
              </div>
            </div>
          </section>';
      }}
        echo'
      </div>
    </div>
  </div> 
</section>';

break;
}?>
<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
</script>
</div>
<?php }?>