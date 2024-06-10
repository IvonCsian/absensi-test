<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$DataOrder = $this->report_model->cekPO();
			if($DataOrder > 0){ 
				$DataResult = $this->report_model->jmPo();
				foreach ($DataResult as $key => $value) {
					$no_bukti_po = $value->no_bukti_po; 
					$tgl_order = $value->tgl_order; 

					$flag_od = $value->flag_od; 
					$flag_bi = $value->flag_bi; 

					if($flag_od == 0){
						$status = "<span class='btn btn-danger btn-sm'>Barang Belum Diorder</span>";
					}
					else if($flag_od == 1){
						$status = "<span class='btn btn-warning btn-sm'>Belum Diproses Penerimaan</span>";
					}
					else if($flag_od == 2 && $flag_bi==1){
						$status = "<span class='btn btn-success btn-sm'>Barang Sudah Diterima</span>";
					}

					echo "
					<div class='card cart-amount-area'>
					$status
					<div class='card-body d-flex align-items-center justify-content-between'>
						<h7 class='total-price mb-0'><font style='color:black'>No.Bukti PO</font></h7>
						<h7 class='total-price mb-0'><font style='color:black'>$no_bukti_po</font></h7>
					</div>

					<div class='table-responsive card-body'>";

					$param = array();
					$param['no_bukti_po'] = $no_bukti_po;
					$DataResultdtl = $this->report_model->dataPOpabrik($param);
					$DataBarang = $this->report_model->jmBarangPo($param);

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
						<button class='btn btn-primary btn-lg w-100' onclick=detailtrans('$no_bukti_po')>Detail</button>
					</div>
					</div><p></p>";
				}
			}
		?>
	</div>
	</div>
</div>
<script type="text/javascript">
	function detailtrans(no_bukti_po){
		window.location.href='<?php echo base_url(); ?>index.php/report/vreportpodetail?no_trans='+no_bukti_po;
	}
</script>