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
  <h1>Data<small> Shift</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Shift Pegawai</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <div class="box-title">
		  <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Baru</button>
		  
		  <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modalUpload"><i class="fa fa-plus"></i> Upload</button>
		  
		 <button type="button" class="btn btn-primary exceltemplate">Template Excel</button>		
		  </div>
          <div class="box-tools pull-right">';
          if($level_user==1){
            echo'
			<table>
				<tr>
					<td>
					
					</td>
					<td>
					 <select class="form-control month" id="bulan" name="bulan" required>';
						if($month ==1){echo'<option value="01" selected>Januari</option>';}else{echo'<option value="01">Januari</option>';}
						if($month ==2){echo'<option value="02" selected>Februari</option>';}else{echo'<option value="02">Februari</option>';}
						if($month ==3){echo'<option value="03" selected>Maret</option>';}else{echo'<option value="03">Maret</option>';}
						if($month ==4){echo'<option value="04" selected>April</option>';}else{echo'<option value="04">April</option>';}
						if($month ==5){echo'<option value="05" selected>Mei</option>';}else{echo'<option value="05">Mei</option>';}
						if($month ==6){echo'<option value="06" selected>Juni</option>';}else{echo'<option value="06">Juni</option>';}
						if($month ==7){echo'<option value="07" selected>Juli</option>';}else{echo'<option value="07">Juli</option>';}
						if($month ==8){echo'<option value="08" selected>Agustus</option>';}else{echo'<option value="08">Agustus</option>';}
						if($month ==9){echo'<option value="09" selected>September</option>';}else{echo'<option value="09">September</option>';}
						if($month ==10){echo'<option value="10" selected>Oktober</option>';}else{echo'<option value="10">Oktober</option>';}
						if($month ==11){echo'<option value="11" selected>November</option>';}else{echo'<option value="11">November</option>';}
						if($month ==12){echo'<option value="12" selected>Desember</option>';}else{echo'<option value="12">Desember</option>';}
					  echo'
					  </select>
					</td>
					<td>
						<select class="form-control year" id="tahun" name="tahun" required>';
							$mulai= date('Y') - 1;
							for($i = $mulai;$i<$mulai + 10;$i++){
								$sel = $i == date('Y') ? ' selected="selected"' : '';
								echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
							}
							echo'
						  </select>
					</td>
					<td>
						<button type="button" class="btn btn-primary viewdt">View</button>		
					</td>
				</tr>
			</table>
           ';
			}
            else{
            echo'<button type="button" class="btn btn-success btn-flat access-failed"><i class="fa fa-plus"></i> Tambah Baru</button>';
            }
            echo'
          </div>
        </div>
            <div class="box-body">
			<div class="progress" id="loading" style="display:none">
			  <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
			</div>
            <div class="table-responsive">
            <div id="div_tabel_data"></div>
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
      <form class="form validate add-shift">
      <div class="modal-body">
        <div class="form-group">
            <label>Tanggal</label>
            <input type="text" class="form-control datepicker" name="tanggal" id="tanggal" required>
        </div>
		<div class="form-group">
            <label>Pegawai</label>
            <select name="employees_id" id="employees_id" class="form-control select2">
				<option value="">--Pilih--</option>';
				 $query="SELECT employees_name,employees_code,id from employees order by id ASC";
				  $result = $connection->query($query);
				  while($row = $result->fetch_assoc()) { 
				  echo'<option value="'.$row['id'].'">'.$row['employees_code'].' - '.$row['employees_name'].'</option>';
				  }echo'
			</select>
        </div>
		<div class="form-group">
            <label>Shift</label>
            <select class="form-control" name="shift_id" id="shift_id" required="">
			  <option value="">- Pilih -</option>';
			  $query="SELECT shift_id,shift_name from shift order by shift_name ASC";
			  $result = $connection->query($query);
			  while($row = $result->fetch_assoc()) { 
			  echo'<option value="'.$row['shift_id'].'">'.$row['shift_name'].'</option>';
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

<!-- upload -->
<div class="modal fade" id="modalUpload" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Baru</h4>
      </div>
     <form id="formModalupload" method="post" action="sw-mod/shiftpegawai/proses.php?action=upload" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
			<label>File</label><br>
			<input type="file" size="60" name="filepegawai">
		</div>
      </div>
      <div class="modal-footer">
		<div class="progress" id="loading2" style="display:none">
		  <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
		</div>
		<p></p>
        <button type="submit" id="btnupload" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Upload</button>
        <button type="button" id="btnclose" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
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
      <form class="form update-shift" method="post">
       <input type="hidden" name="id" id="txtid" required" value="" readonly>
      <div class="modal-body">
          <div class="form-group">
              <label>Tanggal</label>
			  <input type="text" class="form-control datepicker" name="tanggal" id="txttanggal" required>
          </div>
		 
          <div class="form-group">
              <label>Pegawai</label>
              <input type="text" class="form-control" name="employees_name" id="txtemployees_id" readonly>
          </div>

          <div class="form-group">
              <label>Shift</label>
              <select class="form-control" name="shift_id" id="txtshift_id" required="">
				  <option value="">- Pilih -</option>';
				  $query="SELECT shift_id,shift_name from shift order by shift_name ASC";
				  $result = $connection->query($query);
				  while($row = $result->fetch_assoc()) { 
				  echo'<option value="'.$row['shift_id'].'">'.$row['shift_name'].'</option>';
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