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
  <h1>Data<small> Absensi</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Absensi</li>
    </ol>
</section>';
echo'
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
       <div class="box-header">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Absensi Pertanggal</a></li>
            <li><a href="#tab_2" data-toggle="tab">Absensi Perbulan</a></li>
          </ul>
        </div>
        <div class="box-body">
		
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
				
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
				<label>Bidang</label>
				<select name="kd_bidang" id="kd_bidang" class="form-control">
					<option value="">--Pilih--</option>
					<option value="all">Semua Bidang</option>';
					 $query="SELECT * from bidang order by id_bidang ASC";
					  $result = $connection->query($query);
					  while($row = $result->fetch_assoc()) { 
					  echo'<option value="'.$row['kd_bidang'].'">'.$row['kd_bidang'].' - '.$row['nm_bidang'].'</option>';
					  }echo'
				</select>
			   </div>
		    </div>
			<div class="col-md-2">
				<div class="form-group">
				<label>Tanggal</label>
				<input type="text" class="form-control datepicker" name="tanggal" id="tanggal" required>
			    </div>
		    </div>
			<div class="col-md-2">
				<div class="form-group">
				<label>Status Pegawai</label>
				<select name="status_peg" id="status_peg" class="form-control">
				<option value="all">Semua Pegawai</option>';
				    if($row_user['kd_status'] == ""){
					 $query="SELECT * from status_pegawai order by id_status ASC";
				    }
				    else{
				     $query="SELECT * from status_pegawai where status_peg = '".$row_user['kd_status']."' order by id_status ASC";   
				    }
					  $result = $connection->query($query);
					  while($row = $result->fetch_assoc()) { 
					  echo'<option value="'.$row['status_peg'].'">'.$row['status_peg'].'</option>';
					  }echo'
				</select>
			    </div>
		    </div>
			<div class="col-md-2">
				<div class="form-group">
					<label></label><br>
					<button type="button" class="btn btn-primary" onclick="viewdt()">View</button>		
					<button type="button" class="btn btn-success" onclick="exceldt()">Excel</button>	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="progress" id="loading1" style="display:none">
			  <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
			</div>
			<div class="loaddata"></div>
			</div>
		</div>
		
		</div>
			<!-- /.tab-pane -->
		    <div class="tab-pane" id="tab_2">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
						<label>Bidang</label>
						<select name="kdbidang" id="kdbidang" class="form-control">
							<option value="">--Pilih--</option>
							<option value="all">Semua Bidang</option>';
							 $query="SELECT * from bidang order by id_bidang ASC";
							  $result = $connection->query($query);
							  while($row = $result->fetch_assoc()) { 
							  echo'<option value="'.$row['kd_bidang'].'">'.$row['kd_bidang'].' - '.$row['nm_bidang'].'</option>';
							  }echo'
						</select>
					   </div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
						<label>Status Pegawai</label>
						<select name="statuspeg" id="statuspeg" class="form-control">
						<option value="all">Semua Pegawai</option>';
						     
						     if($row_user['kd_status'] == ""){
						         $wherestatus = "";
						     }
						     else{
						         $wherestatus = " WHERE status_peg = '".$row_user['kd_status']."'";
						     }
						     
						    
							 $query="SELECT * from status_pegawai ".$wherestatus." order by id_status ASC";
							  $result = $connection->query($query);
							  while($row = $result->fetch_assoc()) { 
							  echo'<option value="'.$row['status_peg'].'">'.$row['status_peg'].'</option>';
							  }echo'
						</select>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="form-group">
						  <label>Tgl.Awal</label>
						  <input type="text" class="form-control datepicker" name="tgl_awal" id="tgl_awal" required>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="form-group">
						   <label>Tgl.Akhir</label>
						   <input type="text" class="form-control datepicker" name="tgl_akhir" id="tgl_akhir" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label></label><br>
							<button type="button" class="btn btn-primary" onclick="viewdtbln()">View</button>		
							<button type="button" class="btn btn-success" onclick="exceldtbln()">Excel</button>	
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="progress" id="loading2" style="display:none">
					  <div class="progress-bar progress-bar-striped progress-bar-animated active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
					</div>
					<div class="loaddatabln"></div>
					</div>
				</div>
				
		     </div>
			<!-- /.tab-content -->
		</div>
		
		</div>
		
        </div>
    </div>
  </div> 
</section>';
break;

}?>

</div>
<?php }?>