<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$DataOrder = $this->transaksi_model->cekPesanan();
			if($DataOrder > 0){ 
				$DataResult = $this->transaksi_model->jmPesanan();
				foreach ($DataResult as $key => $value) {
					$no_bukti_order = $value->no_bukti_order; 
					$nm_penerima = $value->nm_penerima; 
					$hp = $value->hp_penerima; 
					$nm_agen = $value->nm_agen; 
					$alamat = $value->alamat_penerima; 
					$flag_order = $value->flag_order; 
					$flag_kirim = $value->flag_kirim; 

					if($flag_order == 1 && $flag_kirim == 0){
						$status_od = "<span class='btn btn-danger btn-sm'>Menunggu Diproses Agen</span>";
					}
					else if($flag_order == 2 && $flag_kirim == 0){
						$status_od = "<span class='btn btn-info btn-sm'>Pesanan Diproses $nm_agen</span>";
					}
					else if($flag_order == 2 && $flag_kirim == 1){
						$status_od = "<span class='btn btn-warning btn-sm'>Pesanan Dikirim</span>";
					}

					echo "
					<div class='card cart-amount-area'>
					<div class='card-body d-flex align-items-center justify-content-between'>
						<h7 class='total-price mb-0'><font style='color:black'>No.Order</font></h7>
						<h7 class='total-price mb-0'><font style='color:black'>$no_bukti_order</font></h7>
					</div>

					<div class='table-responsive card-body'>";

					$param = array();
					$param['no_bukti_order'] = $no_bukti_order;
					$DataResultdtl = $this->transaksi_model->dataPesanan($param);
					$DataBarang = $this->transaksi_model->jmBarang($param);

					$nm_barang = $DataResultdtl[0]->nm_barang;

					if($DataBarang == 1){
						$jmbarang = "";
					}
					else{
						$jm_barang = $DataBarang - 1;
						$jmbarang = "<br> + $jm_barang barang lainnya";
					}

					echo "
					<table class='table mb-0'>
						<tbody>
							<tr>
								<td><font style='color:red'><b>$nm_barang</b></font>$jmbarang</td>
							<tr>
						</tbody>
					</table>
					</div>";

					echo "
					<div class='card-body d-flex align-items-center justify-content-between'>
						<h8 class='total-price mb-0'>$status_od</h8>
						<button class='btn btn-primary' onclick=detailtrans('$no_bukti_order')>Detail</button>
					</div>
					</div><p></p>";
				}
			}
		?>
	</div>
	</div>
</div>
<script type="text/javascript">
	function detailtrans(no_bukti_order){
		window.location.href='<?php echo base_url(); ?>index.php/transaksi/vtransaksidetail?no_trans='+no_bukti_order;
	}
</script>