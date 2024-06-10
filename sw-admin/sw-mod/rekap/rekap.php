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
        <div class="box-header with-border">
          <h3 class="box-title"><b>Rekap Data Absensi Per Bidang</b></h3>
          <div class="box-tools pull-right">
           
          </div>
        </div>
        <div class="box-body">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="form-group">
				<label>Bidang</label>
				<select name="kd_bidang" id="kd_bidang" class="form-control">
					<option value="">--Pilih--</option>
					<option value="all">ALL</option>';
					 $query="SELECT * from bidang order by id_bidang ASC";
					  $result = $connection->query($query);
					  while($row = $result->fetch_assoc()) { 
					  echo'<option value="'.$row['kd_bidang'].'">'.$row['kd_bidang'].' - '.$row['nm_bidang'].'</option>';
					  }echo'
				</select>
			   </div>
		    </div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="form-group">
				  <label>Bulan</label>
                  <select class="form-control month" name="bulan" id="bulan" required>';
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
			    </div>
		    </div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="form-group">
				   <label>Tahun</label>
                   <select class="form-control year" name="tahun" id="tahun" required>';
                    $mulai= date('Y') - 1;
                    for($i = $mulai;$i<$mulai + 10;$i++){
                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                        echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                    }
                    echo'
                  </select>
			    </div>
		    </div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="form-group">
					<label></label><br>
					<button type="button" class="btn btn-primary" onclick="viewdt()">View</button>		
					<button type="button" class="btn btn-success" onclick="exceldt()">Excel</button>	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="loaddata"></div>
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