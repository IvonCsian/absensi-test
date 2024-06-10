<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$DataOrder = $this->report_model->cekPembelian();
			if($DataOrder > 0){ 
				$DataResult = $this->report_model->jmPembelian();
				foreach ($DataResult as $key => $value) {
					$no_bukti_bi = $value->no_bukti_bi; 
					$tgl_bi = $value->tgl_bi; 

					echo "
					<div class='card cart-amount-area'>
					<div class='card-body d-flex align-items-center justify-content-between'>
						<h7 class='total-price mb-0'><font style='color:black'>No.Bukti</font></h7>
						<h7 class='total-price mb-0'><font style='color:black'>$no_bukti_bi</font></h7>
					</div>

					<div class='table-responsive card-body'>";

					$param = array();
					$param['no_bukti_bi'] = $no_bukti_bi;
					$DataResultdtl = $this->report_model->dataPembelian($param);
					$DataBarang = $this->report_model->jmBarang($param);

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
						<button class='btn btn-primary btn-lg w-100' onclick=detailtrans('$no_bukti_bi')>Detail</button>
					</div>
					</div><p></p>";
				}
			}
		?>
	</div>
	</div>
</div>
<script type="text/javascript">
	function detailtrans(no_bukti_bi){
		window.location.href='<?php echo base_url(); ?>index.php/report/vreportdetail?no_trans='+no_bukti_bi;
	}
</script>