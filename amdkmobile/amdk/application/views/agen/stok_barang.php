<div class="page-content-wrapper">
      <div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
				   <tr>
					   <td><h6>NAMA BARANG</h6></td>
					   <td><h6>STOK</h6></td>
				   </tr>
				   <?php
				   		$DataResult = $this->stok_model->StokBarangAgen();
						   foreach ($DataResult as $key => $value) {
							   $nm_barang = $value->nm_barang;
							   $kd_barang = $value->kd_barang;
							   $stok_barang = $value->stok_barang;
							   ?>
							   <tr>
									<td><b><?php echo $nm_barang?></b></td>
									<td align="center"><?php echo $stok_barang?></td>
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
		
	</script>