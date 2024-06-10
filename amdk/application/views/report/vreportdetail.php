<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$param = array();
			$param['no_bukti_bi'] = $no_bukti_bi;
			$DataResult = $this->report_model->HeaderBI($param);

			$tgl_bi = $this->func_global->dsql_tglfull($DataResult[0]->tgl_bi);

			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				$no_bukti_bi<br>Tanggal Penerimaan $tgl_bi
			</div>";
			echo "</div><p></p>";

			// --- data barang ---
			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<font size='2' color='red'>Detail Barang</font>
			</div>";
			
			$DataResultdtl = $this->report_model->dataPembelian($param);

			echo "
			<div class='table-responsive card-body'>
			<table class='table mb-0'>
			<tr>
				<th>Barang</th>
				<th style='text-align:center'>Qty</th>
				<th style='text-align:center'>Harga</th>
			</tr>";
				foreach ($DataResultdtl as $key => $dt) {
					$nm_barang = $dt->nm_barang;
					$kd_barang = $dt->kd_barang; 
					$hrg_satuan = $dt->hrg_satuan; 
					$kuantum = $dt->kuantum; 

					echo "
					<tr>
						<td>".$nm_barang."</td>
						<td align='center'>".$kuantum."</td>
						<td align='right'>".$this->func_global->duit($hrg_satuan)."</td>
					</tr>";
				}
				echo "</table>";
			echo "
			</div>
			</div><p></p>";
			
		?>
	</div>
	</div>
</div>
<script type="text/javascript">
	
</script>