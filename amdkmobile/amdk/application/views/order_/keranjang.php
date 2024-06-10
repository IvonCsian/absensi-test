<!-- cart -->
<div class="segments-page">
		<div class="container">
			<div class="pages-title">
				<h3>Cart</h3>
				<div class="line"></div>
			</div>
			<div class="cart">
				<?php 
					$DataOrder = $this->agen_model->cekOrder();
					if($DataOrder > 0){
					$DataResult = $this->agen_model->dataOrder();
					$totalall=0;
					$i=1;
					foreach ($DataResult as $key => $value) {
						$id_od = $value->id_od;
						$no_bukti_po = $value->no_bukti_po;
						$nm_barang = $value->nm_barang;
						$kd_barang = $value->kd_barang; 
						$hrg_satuan = $value->hrg_satuan; 
						$kuantum = $value->kuantum; 
						$totalall += $hrg_satuan * $kuantum;
						?>

						<div class="cart-product first">
							<div class="row">
								<div class="col s4">
									<div class="contents">
										<img src="<?php echo base_url().'libraries/images/product3.png'?>" alt="">
									</div>
								</div>
								<div class="col s6">
									<div class="contents">
										<a href=""><?php echo $nm_barang?></a>
									</div>
								</div>
								<div class="col s2">
									<div class="contents remove">
									<?php echo "<button class='button floating-button button-black z-depth-1' onclick=hapusbarang('$id_od')><i class='fa fa-trash'></i></button>" ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s4">
									<div class="contents">
										<p>Harga Satuan</p>
									</div>
								</div>
								<div class="col s8">
									<!-- <div class="contents"> -->
										<input type="number" id="hrgsatuan<?php echo $i?>" name="hrgsatuan<?php echo $i?>" value="<?php echo $hrg_satuan?>" onkeyup="hitungharga()">
									<!-- </div> -->
								</div>
								<div class="col s4">
									<div class="contents">
										<p>Jumlah</p>
									</div>
								</div>
								<div class="col s6">
									<div class="contents">
										<input type="number" id="qty<?php echo $i?>" name="qty<?php echo $i?>" value="<?php echo $kuantum?>" onkeyup="hitungharga()">

										<input style="display:none" type="number" id="id<?php echo $i?>" name="id<?php echo $i?>" value="<?php echo $id_od?>" readonly>
									</div>
								</div>
							</div>
						</div>

				<?php	$i++;}
					}else{
						echo "<h3><i class='fa fa-shopping-cart'></i>  Keranjang Kosong</h3><p></p>";
					}
				?>
				
			</div>
			<?php if($DataOrder > 0){?>
			<div class="total-pay">
				<div class="row">
					<div class="col s8">
						<div class="contents">
							<p>Order Number</p>
						</div>
					</div>
					<div class="col s4">
						<div class="contents right">
							<p><?php echo $no_bukti_po?></p>
							<input style="display:none" type="text" name="no_bukti" id="no_bukti" value="<?php echo $no_bukti_po?>" readonly>
						</div>
					</div>
					<div class="col s8">
						<div class="contents">
							<h5>Total Harga</h5>
						</div>
					</div>
					<div class="col s4">
						<div class="contents right">
							<h5><div id="totalharga"></div></h5>
						</div>
					</div>
				</div>
				<button class="button" onclick="ordersupplier()"><i class="fa fa-send"></i>Proceed to Order</button>
			</div>
			<?php }?>
		</div>
	</div>
	<!-- end cart -->

	<script type="text/javascript">
		

		function hitungharga(){
			var totalharga = 0;
			var i=1;
			for(i=1;i< <?php echo $i?>;i++){
				
				var hrgsatuan = document.getElementById('hrgsatuan'+i).value;
				var qty = document.getElementById('qty'+i).value;
				totalharga += hrgsatuan * qty;
			}
			document.getElementById("totalharga").innerHTML = totalharga;
		}

		hitungharga();

		function hapusbarang(id_od){
			$.ajax({
					type: 'POST',
					url : 'hapus_po_agendtl',
					data: 'id_od='+id_od,	
					beforeSend : function() {
					},
					success: function(msg){
						if(msg == 1){
							alert('Barang Berhasil Dihapus');
							location.reload();
						}
					}
			});
		}

		function ordersupplier(){
			param = "";
			var no_bukti = document.getElementById('no_bukti').value;

			var i=1;
			for(i=1;i< <?php echo $i?>;i++){
				var hrgsatuan = document.getElementById('hrgsatuan'+i).value;
				var qty = document.getElementById('qty'+i).value;
				var id = document.getElementById('id'+i).value;

				param += "data_i"+i+"="+document.getElementById('hrgsatuan'+i).value+"&";
				param += "data_j"+i+"="+document.getElementById('qty'+i).value+"&";
				param += "data_k"+i+"="+document.getElementById('id'+i).value+"&";
			}
			

			param += "no_bukti="+no_bukti+"&jumlahdata="+i;
				$.ajax({
				url : 'update_order_supplier',
				data : param,
				type : "POST",
				beforeSend : function() {
					
				},
				success : function(res) {
					if (res == 1) {
						alert("Barang Berhasil Diorder");
						window.location.href='<?php echo base_url(); ?>index.php/Welcome/sukses';
					}
					
				}
			});
		}

		
	</script>