<?php if(empty($connection)){
  header('location:./404');
} else {
    if($row_user['level'] == "1"){
        echo'<aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <div class="slimScrollDiv">
            <section class="sidebar">
              <!-- Sidebar user panel -->
            
              <!-- sidebar menu: : style can be found in sidebar.less -->
              <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>';
              if($mod =='home'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./"><i class="fa fa-home"></i><span>Dashboard</span></a></li>';
              
              if($mod =='karyawan' OR $mod=='jabatan' OR $mod=='shift' OR $mod=='lokasi' OR $mod=='kerja' OR $mod=='shiftpegawai' OR $mod=='bidang' OR $mod=='office' OR $mod=='statuspegawai'){echo'<li class="active treeview">'; }else{
              echo'<li class="treeview">';}
              echo'
                  <a href="#">
                    <i class="fa fa-database"></i> <span>Master Data</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">';
                     if($mod =='karyawan'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="./karyawan"><i class="fa fa-circle-o"></i> Data Karyawan</a></li>';
                    if($mod =='jabatan'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="./jabatan"><i class="fa fa-circle-o"></i> Data Jabatan</a></li>';
                    if($mod =='shift'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="shift"><i class="fa fa-circle-o"></i> Data Jam Kerja</a></li>';
        			if($mod =='bidang'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="bidang"><i class="fa fa-circle-o"></i> Data Bidang</a></li>';
        			if($mod =='statuspegawai'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="./statuspegawai"><i class="fa fa-circle-o"></i> Data Status Pegawai</a></li>';
        			if($mod =='shiftpegawai'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="./shiftpegawai"><i class="fa fa-circle-o"></i> Data Pegawai Shift</a></li>';
        			if($mod =='kerja'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="./kerja"><i class="fa fa-circle-o"></i> Data Status Kerja</a></li>';
        			 if($mod =='office'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="./office"><i class="fa fa-circle-o"></i> Data Lokasi Kerja Pegawai</a></li>';
                     if($mod =='lokasi'){echo'<li class="active">'; }else{echo'<li>';}
                     echo'<a href="./lokasi"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
        			 
        			 
                  </ul>
                </li>';
        
              if($mod =='cuty'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./cuty"><i class="fa fa-calendar" aria-hidden="true"></i> <span>Data Permohonan Cuti</span></a></li>';
        	  
        	  if($mod =='sppd'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./sppd"><i class="fa fa-calendar" aria-hidden="true"></i> <span>Data Permohonan SPPD</span></a></li>';
        
        	  if($mod =='izin'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./izin"><i class="fa fa-calendar" aria-hidden="true"></i> <span>Data Permohonan Izin</span></a></li>';
        	  
              if($mod =='absensi'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./absensi"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Data Absensi</span></a></li>';
        	  
        	  if($mod =='report'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./report"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Report Absensi</span></a></li>';
        	  
        	  if($mod =='rekap'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./rekap"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Report Rekap Absensi</span></a></li>';
        
               if($mod =='job'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./job"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Report Pekerjaan</span></a></li>';
        
              if($mod =='setting'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./setting"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Pengaturan Web</span></a></li>';
        
              if($mod =='user'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./user"><i class="fa fa-user"></i> <span>Admin</span></a></li>';?>
              <li><a href="javascript:void();" onClick="location.href='./logout';"><i class="fa fa-sign-out text-red"></i>  <span>Keluar</span></a></li>
          <?php echo'
              </ul>
            </section>
          </div>
            <!-- /.sidebar -->
          </aside>';
    }
    else{
        echo'<aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <div class="slimScrollDiv">
            <section class="sidebar">
              <!-- Sidebar user panel -->
            
              <!-- sidebar menu: : style can be found in sidebar.less -->
              <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>';
              if($mod =='home'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./"><i class="fa fa-home"></i><span>Dashboard</span></a></li>';
              
              if($mod =='absensi'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./absensi"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Data Absensi</span></a></li>';
        	  
        	  if($mod =='report'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./report"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Report Absensi</span></a></li>';
        	  
        	  if($mod =='rekap'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./rekap"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Report Rekap Absensi</span></a></li>';
        
               if($mod =='job'){echo'<li class="active">'; }else{echo'<li>';}
              echo'<a href="./job"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Report Pekerjaan</span></a></li>';
        
              if($mod =='user'){echo'<li class="active">'; 
                  
              }else{echo'';}
              echo'';?>
              <li><a href="javascript:void();" onClick="location.href='./logout';"><i class="fa fa-sign-out text-red"></i>  <span>Keluar</span></a></li>
          <?php echo'
              </ul>
            </section>
          </div>
            <!-- /.sidebar -->
          </aside>';
    }
  }?>