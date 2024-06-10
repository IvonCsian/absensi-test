<div class="page-content-wrapper">
      <div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
				   <tr>
				   	   <td></td>
					   <td><h7><b>NAMA BARANG</b></h7></td>
					   <td><h7><b>HARGA BELI</b></h7></td>
					   <td><h7><b>HARGA JUAL</b></h7></td>
				   </tr>
				   <?php
				   		$DataResult = $this->harga_model->HargaBarangAgen();
						   foreach ($DataResult as $key => $value) {
							   $nm_barang = $value->nm_barang;
							   $kd_barang = $value->kd_barang;
							   $hrg_beli = $value->hrg_satuan; 
							   $hrg_jual = $value->hrg_jual; 

							   ?>
							   <tr>
									<th scope="row">
										<?php echo "<button class='btn btn-success btn-sm' onclick=updateharga('$kd_barang')>Update</button>" ?>
									</th>
									<td><b><?php echo $nm_barang?></b></td>
									<td align="right">
										Rp <?php echo $this->func_global->duit($hrg_beli)?>
						   			</td>
									<td align="right">
										Rp <?php echo $this->func_global->duit($hrg_jual)?>
									</td>
							   </tr>
							    
					<?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          
        </div>
      </div>
    </div>
	
	<script type="text/javascript">
		function updateharga(kd_barang){
			window.location.href='<?php echo base_url(); ?>index.php/harga/hargajual?kd_barang='+kd_barang;
		}
	</script>