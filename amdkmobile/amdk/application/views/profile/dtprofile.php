<div class="page-content-wrapper">
      <div class="container">
        <!-- Profile Wrapper-->
        <div class="profile-wrapper-area py-3">
          <!-- User Information-->
          <div class="card user-info-card">
            <div class="card-body p-4 d-flex align-items-center">
              <div class="user-profile me-3"><img src="img/bg-img/9.jpg" alt="">
                <div class="change-user-thumb">
                  <form>
                    <input class="form-control-file" type="file">
                    <button><i class="lni lni-pencil"></i></button>
                  </form>
                </div>
              </div>
              <div class="user-info">
                <p class="mb-0 text-dark"><?php echo $username?></p>
                <h5 class="mb-0"><?php echo $nama?></h5>
              </div>
            </div>
          </div>
          <!-- User Meta Data-->
          <div class="card user-data-card">
            <div class="card-body">
              <form action="" method="">
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-user"></i><span>Username</span></div>
                  <input class="form-control" type="text" value="<?php echo $username?>" readonly>
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-user"></i><span>Nama</span></div>
                  <input class="form-control" type="text" value="<?php echo $nama?>">
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-phone"></i><span>Telp / HP</span></div>
                  <input class="form-control" type="text" value="<?php echo $telp?>">
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-map-marker"></i><span>Alamat</span></div>
                  <input class="form-control" type="text" value="<?php echo $alamat?>">
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-map-marker"></i><span>Koordinat</span></div>
                  <!-- <div id="mapa"></div> -->
                  <input class="form-control" type="text" value="<?php echo $koordinat?>">
                  <!-- <input type="text" name='latitude' id='latitude'>
                  <input type="text" name='longitude' id='longitude'> -->
                </div>
                <button class="btn btn-success w-100" type="submit">Update Data</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
	
	<script type="text/javascript">
		if (GBrowserIsCompatible()) 
    {
        map = new GMap2(document.getElementById("mapa"));
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl(3));    
        map.setCenter( new GLatLng(-7.793997,110.36931), 11,0);
        
        // GEvent.addListener(map,'mousemove',function(point)
        // {
        //     document.getElementById('latspan').innerHTML = point.lat()
        //     document.getElementById('lngspan').innerHTML = point.lng()
        //     document.getElementById('latlong').innerHTML = point.lat() + ', ' + point.lng()                        
        // });
        
        GEvent.addListener(map,'click',function(overlay,point)
        {
            document.getElementById('latlongclicked').value = point.lat() + ', ' + point.lng()
            document.getElementById('latitude').value = point.lat() 
            document.getElementById('longitude').value = point.lng()
        });
    }
	</script>