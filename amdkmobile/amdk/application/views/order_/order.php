<!-- slide -->
<div class="slide">
		<div class="slide-show owl-carousel owl-theme">
			<div class="slide-content">
				<div class="mask"></div>
				<img src="images/slider-home1.jpg" alt="">
				<div class="caption text-center">
					<h2>Welcome to Flyors</h2>
					<p>Mobile Templates</p>
					<button class="button">Shop Now</button>
				</div>
			</div>
			<div class="slide-content">
				<div class="mask"></div>
				<img src="images/slider-home2.jpg" alt="">
				<div class="caption center">
					<h2>Good Design Implementation</h2>
					<p>Mobile Templates</p>
					<button class="button">Shop Now</button>
				</div>
			</div>
			<div class="slide-content">
				<div class="mask"></div>
				<img src="images/slider-home3.jpg" alt="">
				<div class="caption text-center">
					<h2>Great & Easy to Customize</h2>
					<p>Mobile Templates</p>
					<button class="button">Shop Now</button>
				</div>
			</div>
			<div class="slide-content">
				<div class="mask"></div>
				<img src="images/slider-home4.jpg" alt="">
				<div class="caption center">
					<h2>We Are Design Agency</h2>
					<p>Mobile Templates</p>
					<button class="button">Shop Now</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end slide -->
<!-- shop -->
<div class="shop segments">
		<div class="container">
			<div class="row">
				<?php 
					$DataResult = $this->agen_model->dataBarang();
					foreach ($DataResult as $key => $value) {
						$nm_barang = $value->nm_barang;
						$kd_barang = $value->kd_barang; ?>

						<div class="col s6">
							<div class="contents">
								<img src="<?php echo base_url().'libraries/images/product1.png'?>" alt="">
								<a href="">
									<h6><?php echo $value->nm_barang?></h6>
								</a>
								<?php echo "<button class='button button-full z-depth-1' onclick=orderagen('$value->kd_barang')>Order</button>" ?>
							</div>
						</div>
				<?php	}
				?>
				
			</div>
			<div class="row">
				<button class="button button-full z-depth-1" onclick="checkout()">Keranjang</button>
			</div>
			<!-- <div class="pagination">
				<ul>
					<li class="disabled"><a class="z-depth-1" href="">1</a></li>
					<li><a href="">2</a></li>
					<li><a href="">3</a></li>
					<li><a href="">4</a></li>
					<li><a href="">5</a></li>
				</ul>
			</div> -->
		</div>
	</div>
	<!-- shop -->

	<script type="text/javascript">

	function orderagen(kd_barang) {
			$.ajax({
				type: 'POST',
				url : 'ins_po_agen',
				data: 'kd_barang='+kd_barang,
				beforeSend : function() {
				},
				success: function(msg){
					if(msg == 1){
						alert('Data Berhasil Ditambahkan');
					}
				}
		});
	}

	function checkout() {
		window.location.href='<?php echo base_url(); ?>index.php/agen/ordercheckout';
	}
	</script>