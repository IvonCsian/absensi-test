<div class="page-content-wrapper">
      <!-- Top Products-->
      <div class="top-products-area py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6>Order Pembelian Barang</h6>
          </div>
          <div class="product-catagories">
            
          </div>
          <div class="row g-3">
            <!-- Single Weekly Product Card-->
			<?php 
				$DataResult = $this->order_model->dataBarangAgen();
				foreach ($DataResult as $key => $value) {
					$nm_barang = $value->nm_barang;
					$kd_barang = $value->kd_barang;
					$hrg_satuan = $value->hrg_satuan;
					
					// --- cek harga barang ---
					// $param = array();
					// $param['kd_barang'] = $kd_barang;
					// $HargaBarang = $this->penerimaan_model->cekHarga($param);
					// $hrg_satuan = $HargaBarang[0]->hrg_satuan;
					?>

				<div class="col-12 col-md-6">
					<div class="card weekly-product-card">
						<div class="card-body d-flex align-items-center">
						<div class="product-thumbnail-side"><a class="wishlist-btn" href="#"><i class="lni lni-heart"></i></a><a class="product-thumbnail d-block" href="single-product.html"><img src="<?php echo base_url().'libraries/dist/img/product/10.png'?>" alt=""></a></div>
						<div class="product-description"><a class="product-title d-block" href="single-product.html"><?php echo $nm_barang?></a>
							<?php echo "<button class='btn btn-success btn-sm' onclick=barangmasuk('$value->kd_barang')><i class='me-1 lni lni-plus'></i>Order</button>" ?>
						</div>
						</div>
					</div>
				</div>

			<?php }?>

				<div class="col-12 col-md-6">
					<div class="card weekly-product-card">
						<?php echo "<button class='btn btn-warning btn-lg w-100' onclick=checkout()><i class='me-1 lni lni-cart'></i>Checkout</button>" ?>
					</div>
				</div>
            
            
          </div>
        </div>
      </div>
    </div>

	<script type="text/javascript">

	function barangmasuk(kd_barang) {
			$.ajax({
				type: 'POST',
				url : 'ins_order_header',
				data: 'kd_barang='+kd_barang,
				beforeSend : function() {
				},
				success: function(msg){
					if(msg == 1){
						alert('Barang Berhasil Ditambahkan');
					}
				}
		});
	}

	function checkout() {
		window.location.href='<?php echo base_url(); ?>index.php/order/checkout';
	}
	</script>