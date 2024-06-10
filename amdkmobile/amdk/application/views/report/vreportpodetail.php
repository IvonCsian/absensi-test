<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$param = array();
			$param['no_bukti_po'] = $no_bukti_po;
			$DataResult = $this->report_model->HeaderPO($param);

			$tgl_order = $this->func_global->dsql_tglfull($DataResult[0]->tgl_order);
			$flag_od = $DataResult[0]->flag_od;

			if($flag_od == 0 || $flag_od == 1){
				$btncancel = "<button class='btn btn-danger btn-lg w-100' onclick=hapusorder('$no_bukti_po')>Hapus Order</button>";
			}
			else{
				$btncancel = "";
			}

			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				$no_bukti_po<br>Tanggal Order $tgl_order
			</div>";
			echo "</div><p></p>";

			// --- data barang ---
			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<font size='2' color='red'>Detail Barang</font>
			</div>";
			
			$DataResultdtl = $this->report_model->dataPOpabrik($param);

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
			<div class='card-body d-flex align-items-center center-content-between'>
			$btncancel
			</div>
			</div><p></p>";
			
		?>
	</div>
	</div>
</div>
<script type="text/javascript">
	function hapusorder(no_bukti_po){
		$.ajax({
				type: 'POST',
				url : 'cancel_po',
				data: 'no_bukti_po='+no_bukti_po,	
				beforeSend : function() {
				},
				success: function(msg){
					if(msg == 1){
						alert('PO berhasil dibatalkan');
						window.location.href='vreportpo';
					}
				}
		});
	}
</script>