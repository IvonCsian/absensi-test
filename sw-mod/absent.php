<?php 
if ($mod ==''){
    header('location:../404');
    echo'kosong';
}else{
    include_once 'sw-mod/sw-header.php';
if(!isset($_COOKIE['COOKIES_MEMBER']) && !isset($_COOKIE['COOKIES_COOKIES'])){
        setcookie('COOKIES_MEMBER', '', 0, '/');
        setcookie('COOKIES_COOKIES', '', 0, '/');
        // Login tidak ditemukan
        setcookie("COOKIES_MEMBER", "", time()-$expired_cookie);
        setcookie("COOKIES_COOKIES", "", time()-$expired_cookie);
        session_destroy();
        header("location:./"); 
}else{

  echo'<!-- App Capsule -->
    <div id="appCapsule">
        <!-- Wallet Card -->
        <div class="section wallet-card-section pt-1">
            <div class="wallet-card">
                <div class="balance">
                    <div class="left">
                        <span class="title"> Selamat '.$salam.'</span>
                        <h4>'.ucfirst($row_user['employees_name']).' ('.ucfirst($row_user['employees_code']).')</h4>
                    </div>
                    <div class="right">
                        <span class="title">'.tgl_ind($date).' </span>
                        <h4><span class="clock"></span></h4>
                    </div>

                </div>
                <!-- * Balance -->
                <div class="text-center">
                <!--<h3>'.tgl_ind($date).' - <span class="clock"></span></h3>-->
                <p>Lat-Long: <span class="latitude" id="latitude"></span></p>
				
				<button type="button" class="btn btn-warning btn-xs btn-modal enable-tooltip" title="Lokasi">Lokasi</button>
				
				<div class="form-group">
					<label>Shift</label>
					<select class="form-control" name="shift_id" id="shift_id">
					  <option value="">- Pilih -</option>';
					  $query="SELECT shift_id,shift_name,time_in,time_out from shift order by shift_name ASC";
					  $result = $connection->query($query);
					  while($row = $result->fetch_assoc()) { 
					  echo'<option value="'.$row['shift_id'].'">'.$row['shift_name'].' ( '.$row['time_in'].' s.d '.$row['time_out'].')</option>';
					  }echo'
					</select>
				</div>
				
				<div class="form-group">
					<label>Kantor</label>
					<select class="form-control" name="building_id" id="building_id" required>';
					  $query="SELECT m.* FROM (SELECT a.building_id,b.name FROM employees a 
						LEFT JOIN building b ON a.building_id = b.building_id
						WHERE a.employees_code = '".ucfirst($row_user['employees_code'])."'
						UNION
						SELECT a.building_id,b.name FROM office_employees a 
						LEFT JOIN building b ON a.building_id = b.building_id
						WHERE a.employees_code = '".ucfirst($row_user['employees_code'])."') m";
					  $result = $connection->query($query);
					  while($row = $result->fetch_assoc()) { 
					  echo'<option value="'.$row['building_id'].'">'.$row['name'].'</option>';
					  }echo'
					</select>
				</div>
				
				</div>
                <div class="wallet-footer text-center">
                    <div class="webcam-capture-body text-center">';
                    // ========== Cek untuk deteksi Device ===================//
                    if($mobile =='true'){
						
                        echo'
                        <div class="webcam-camera">
                             <img src="sw-content/camera.png">';
                             if($result_absent->num_rows > 0){
                                echo'
                                <button class="btn btn-success btn-lg btn-block"><ion-icon name="camera-outline"></ion-icon>Absen Pulang<input type="file" name="webcam" id="webcam" accept="image/jpg, image/gif, image/jpeg" capture="environment"></button>';}
                                else{
                                echo'
                                <button class="btn btn-success btn-lg btn-block"><ion-icon name="camera-outline"></ion-icon>Absen Masuk<input type="file" name="webcam" id="webcam" accept="image/jpg, image/gif, image/jpeg" capture="environment"></button>';}
                            echo'
                        </div>';
                    }
                    else{
                        echo'<div class="webcam-capture"></div>
                        <div class="form-group basic">';
                            if($result_absent->num_rows > 0){
                                echo'
                                <button class="btn btn-success btn-lg btn-block" onClick="captureimage(0)"><ion-icon name="camera-outline"></ion-icon>Absen Pulang</button>';}
                                else{
                                echo'
                                <button class="btn btn-success btn-lg btn-block" onClick="captureimage(0)"><ion-icon name="camera-outline"></ion-icon>Absen Masuk</button>';}
                        echo'
                        </div>';
                    }
                echo'
                    </div>
                </div>
                <!-- * Wallet Footer -->
				
            </div>
        </div>
        <!-- Card -->
    </div>
    <!-- * App Capsule -->
	
	<div class="modal fade" id="modal-location">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Lokasi Absen <span class="modal-title-name"></span></h4>
		  </div>
		  <div class="modal-body">
			<div id="iframe-map"></div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
';

  }
  include_once 'sw-mod/sw-footer.php';
} ?>