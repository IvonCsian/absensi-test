<div class="page-content-wrapper">
      <div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
				   <?php 
				   		$DataOrder = $this->penerimaan_model->cekOrder();
						   if($DataOrder > 0){
						   $DataResult = $this->penerimaan_model->dataOrder();
						   $totalall=0;
						   $i=1;
						   foreach ($DataResult as $key => $value) {
							   $id_bi = $value->id_bi;
							   $no_bukti_bi = $value->no_bukti_bi;
							   $nm_barang = $value->nm_barang;
							   $kd_barang = $value->kd_barang; 
							   $hrg_satuan = $value->hrg_satuan; 
							   $kuantum = $value->kuantum; 
							   $totalall += $hrg_satuan * $kuantum;?>

						<tr>
							<th scope="row">
								<?php echo "<button class='btn btn-danger btn-sm' onclick=hapusbarang('$id_bi')><i class='me-1 lni lni-trash'></i></button>" ?>
							</th>
							<td><img src="<?php echo base_url().'libraries/dist/img/product/11.png'?>" alt=""></td>
							<td><?php echo $nm_barang?></td>
							<td>
							<div class="quantity">
								<input type="number" class="qty-text" id="qty<?php echo $i?>" name="qty<?php echo $i?>" value="<?php echo $kuantum?>" onkeyup="hitungharga()">
							</div>
							</td>
							<tr>
								<td>Harga Satuan</td>
								<td colspan="3">
									<input type="number" class="form-control" id="hrgsatuan<?php echo $i?>" name="hrgsatuan<?php echo $i?>" value="<?php echo $hrg_satuan?>" onkeyup="hitungharga()">
									<input style="display:none" type="number" id="id<?php echo $i?>" name="id<?php echo $i?>" value="<?php echo $id_bi?>" readonly>
								</td>
							</tr>
						</tr> 
				   <?php	$i++;}
					}else{?>
						<div class="card-body d-flex align-items-center justify-content-between">
							<h5 class="total-price mb-0">Data Tidak Ada</h5>
						</div>
					<?php }
				?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Cart Amount Area-->
		  <?php if($DataOrder > 0){?>
          <div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
			  <h7 class="total-price mb-0">No.Bukti</h7>
			  <h7 class="total-price mb-0"><?php echo $no_bukti_bi?></h7>
			  <input style="display:none" type="text" name="no_bukti" id="no_bukti" value="<?php echo $no_bukti_bi?>" readonly>
            </div>
          </div>
		  
		  <p></p>
          <!-- Cart Amount Area-->
          <div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
			  <h5 class="total-price mb-0">Rp</h5>
              <h5 class="total-price mb-0"><div id="totalharga"></div></h5>
			  <button class="btn btn-warning" onclick="savebi()">Simpan</button>
            </div>
          </div>
		  <?php }?>
        </div>
      </div>
    </div>
	
	<script type="text/javascript">
		$(document).ready(function(){
			hitungharga();
		})
		
		function hapusbarang(id_bi){
			$.ajax({
					type: 'POST',
					url : 'hapus_bi_dtl',
					data: 'id_bi='+id_bi,	
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

		function hitungharga(){
			var totalharga = 0;
			var i=1;
			for(i=1;i< <?php echo $i?>;i++){
		
				var hrgsatuan = $('#hrgsatuan'+i).val();
				var qty = $('#qty'+i).val();
				totalharga += hrgsatuan * qty;
			}
			document.getElementById("totalharga").innerHTML = totalharga;
		}
		
		

		function savebi(){
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
				url : 'simpan_bi_dtl',
				data : param,
				type : "POST",
				beforeSend : function() {
					
				},
				success : function(res) {
					if (res == 1) {
						alert("Data Berhasil Disimpan");
						window.location.href='<?php echo base_url(); ?>index.php/Welcome/sukses';
					}
					
				}
			});
		}
	</script>