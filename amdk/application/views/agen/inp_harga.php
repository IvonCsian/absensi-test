<div class="page-content-wrapper">
      <div class="container">
        <!-- Profile Wrapper-->
        <div class="profile-wrapper-area py-3">
          <!-- User Information-->
          <div class="card user-info-card">
            
          </div>
          <!-- User Meta Data-->
		 
          <div class="card user-data-card">
            <div class="card-body">
              <form id="formModal" onsubmit="return false">
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-folder"></i><span>Kode Barang</span></div>
                  <input class="form-control" type="text" name="kd_barang" id="kd_barang" value="<?php echo $kd_barang?>" readonly>
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-folder"></i><span>Nama Barang</span></div>
                  <input class="form-control" type="text" name="nm_barang" id="nm_barang" value="<?php echo $nm_barang?>" readonly>
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-cart"></i><span>Harga Beli</span></div>
                  <input class="form-control" type="text" name="hrg_beli" id="hrg_beli" value="<?php echo $this->func_global->duit($hrg_beli)?>" readonly>
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-money-location"></i><span>Harga Jual</span></div>
                  <input class="form-control" type="number" name="hrg_jual" id="hrg_jual" value="<?php echo $this->func_global->duit($hrg_jual)?>">
                </div>
                <button class="btn btn-success w-100" type="submit" onclick=simpanharga()>Update Harga</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
	
	<script type="text/javascript">
		function simpanharga(){
			var hrg_jual = $('#hrg_jual').val();
			var kd_barang = $('#kd_barang').val();
				$.ajax({
					type: 'POST',
					url : 'update_harga_jual',
					data: 'hrg_jual='+hrg_jual+'&kd_barang='+kd_barang,
					beforeSend : function() {
					},
					success: function(msg){
						if(msg == 1){
							alert('Harga Berhasil Diupdate');
							window.location.href='<?php echo base_url(); ?>index.php/harga/hargabarang';
						}
					}
			});
		}
	</script>