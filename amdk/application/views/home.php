
    <!-- PWA Install Alert-->
    <!-- <div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
      <div class="toast-body">
        <div class="content d-flex align-items-center mb-2"><img src="img/icons/icon-72x72.png" alt="">
          <h6 class="mb-0">Add to Home Screen</h6>
          <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
        </div><span class="mb-0 d-block">Add Suha on your mobile home screen. Click the<strong class="mx-1">"Add to Home Screen"</strong>button &amp; enjoy it like a regular app.</span>
      </div>
    </div> -->
    <div class="page-content-wrapper">
      <div class="container">
        <div class="pt-3">
          <!-- Hero Slides-->
          <div class="hero-slides owl-carousel">
            <!-- Single Hero Slide-->
            <div class="single-hero-slide" style="background-image: url('<?php echo base_url()?>libraries/dist/img/bg-img/1.jpg')">
              <div class="slide-content h-100 d-flex align-items-center">
                <div class="slide-text">
                  <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Amazon Echo</h4>
                  <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">3rd Generation, Charcoal</p><a class="btn btn-primary btn-sm" href="#" data-animation="fadeInUp" data-delay="800ms" data-duration="1000ms">Buy Now</a>
                </div>
              </div>
            </div>
            <!-- Single Hero Slide-->
            <div class="single-hero-slide" style="background-image: url('<?php echo base_url()?>libraries/dist/img/bg-img/2.jpg')">
              <div class="slide-content h-100 d-flex align-items-center">
                <div class="slide-text">
                  <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Light Candle</h4>
                  <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">Now only $22</p><a class="btn btn-success btn-sm" href="#" data-animation="fadeInUp" data-delay="500ms" data-duration="1000ms">Buy Now</a>
                </div>
              </div>
            </div>
            <!-- Single Hero Slide-->
            <div class="single-hero-slide" style="background-image: url('<?php echo base_url()?>libraries/dist/img/bg-img/3.jpg')">
              <div class="slide-content h-100 d-flex align-items-center">
                <div class="slide-text">
                  <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">Best Furniture</h4>
                  <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">3 years warranty</p><a class="btn btn-danger btn-sm" href="#" data-animation="fadeInUp" data-delay="800ms" data-duration="1000ms">Buy Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Product Catagories-->
      <div class="product-catagories-wrapper py-3">
        <div class="container">
          <div class="section-heading">
            <h6>Menu</h6>
          </div>
          <div class="product-catagory-wrap">
            <div class="row g-3">
              <!-- Single Catagory Card-->
              <div class="col-4">
                <div class="card catagory-card">
                  <div class="card-body"><a class="text-danger" href="<?php echo base_url(); ?>index.php/terima/apporder"><i class="lni lni-shopping-basket"></i><span>Order Masuk</span></a></div>
                </div>
              </div>
                <!-- Single Catagory Card-->
              <div class="col-4">
                <div class="card catagory-card">
                  <div class="card-body"><a class="text-danger" href="<?php echo base_url(); ?>index.php/purchase/inputpo"><i class="lni lni-cart-full"></i><span>PO Pabrik</span></a></div>
                </div>
              </div>
              <!-- Single Catagory Card-->
              <div class="col-4">
                <div class="card catagory-card">
                  <div class="card-body"><a class="text-danger" href="<?php echo base_url(); ?>index.php/barangmasuk/barangmasuk"><i class="lni lni-inbox"></i><span>Barang Masuk</span></a></div>
                </div>
              </div>

              <!-- Single Catagory Card-->
              <div class="col-4">
                <div class="card catagory-card">
                  <div class="card-body"><a class="text-danger" href="<?php echo base_url(); ?>index.php/harga/hargabarang"><i class="lni lni-tag"></i><span>Harga</span></a></div>
                </div>
              </div>

              <!-- Single Catagory Card-->
              <div class="col-4">
                <div class="card catagory-card">
                  <div class="card-body"><a class="text-danger" href="<?php echo base_url(); ?>index.php/history/vhistoryagen"><i class="lni lni-layers"></i><span>Riwayat</span></a></div>
                </div>
              </div>

              

              <!-- Single Catagory Card-->
              <div class="col-4">
                <div class="card catagory-card">
                  <div class="card-body"><a class="text-danger" href="<?php echo base_url(); ?>index.php/stok/stokbarang"><i class="lni lni-database"></i><span>Stok</span></a></div>
                </div>
              </div>
            

            </div>
          </div>
        </div>
      </div>

      <!-- Featured Products Wrapper-->
      <div class="featured-products-wrapper py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6>Produk Jual</h6>
          </div>
          <div class="row g-3">
		    <?php 
				$DataResult = $this->agen_model->dataBarang();
				foreach ($DataResult as $key => $value) {
					$nm_barang = $value->nm_barang;
					$hrg_jual = $value->hrg_jual;
					$kd_barang = $value->kd_barang; ?>

					<!-- Featured Product Card-->
					<div class="col-6 col-md-4 col-lg-3">
					<div class="card featured-product-card">
						<div class="card-body"><span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>
						<div class="product-thumbnail-side"><a class="wishlist-btn" href="#"><i class="lni lni-heart"></i></a><a class="product-thumbnail d-block" href="single-product.html"><img src="img/product/14.png" alt=""></a></div>
						<div class="product-description"><a class="product-title d-block" href="single-product.html"><?php echo $nm_barang?></a>
							<p class="sale-price"><?php echo $this->func_global->duit($hrg_jual)?></p>
						</div>
						</div>
					</div>
					</div>

			<?php }?>

          </div>
        </div>
      </div>
    </div>
    