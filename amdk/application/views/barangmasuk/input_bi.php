<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$DataOrder = $this->bi_model->cekPesanan();
			if($DataOrder > 0){ 
				$DataResult = $this->bi_model->jmPesanan();
				foreach ($DataResult as $key => $value) {
					$no_bukti_po = $value->no_bukti_po; 

					echo "
					<div class='card cart-amount-area'>
					<div class='card-body d-flex align-items-center justify-content-between'>
						<h7 class='total-price mb-0'><font style='color:black'>No.Bukti PO</font></h7>
						<h7 class='total-price mb-0'><font style='color:black'>$no_bukti_po</font></h7>
					</div>

					<div class='cart-table card mb-3'>
					<div class='table-responsive card-body'>";

					$param = array();
					$param['no_bukti_po'] = $no_bukti_po;
					$DataResultdtl = $this->bi_model->dataPesanan($param);

					echo "<table class='table mb-0'>
					<tbody>
					<tr>
						<td colspan='2'><font style='color:red' size='2'><b>Data Order</b></font></td>
					<tr>";
					$grandtotal=0;
					foreach ($DataResultdtl as $key => $dt) {
						$nm_barang = $dt->nm_barang;
						$kd_barang = $dt->kd_barang; 
						$hrg_satuan = $dt->hrg_satuan; 
						$kuantum = $dt->kuantum; 
						$total = $kuantum*$hrg_satuan;
						echo "
						<tr>
							<td>".$nm_barang."</td>
							<td align='center'>".$kuantum."</td>
							<td align='right'>".$this->func_global->duit($hrg_satuan)."</td>
							<td align='right'>".$this->func_global->duit($total)."</td>
						</tr>";
						
						$grandtotal+= $total;
					}
					echo "</tbody>
						<tr>
							<td colspan='3'><font style='color:black' size='2'>Total</font></td>
							<td align='right'><font style='color:black' size='2'>".$this->func_global->duit($grandtotal)."</font></td>
						</tr>
					</table>
					</div>
					</div>";

					echo "
					<div class='card-body d-flex align-items-center center-content-between'>
					<button class='btn btn-warning btn-lg w-100' onclick=apporder('$no_bukti_po')>Terima Barang</button>
					</div>
					</div><p></p>";
				}
			}
		?>
	</div>
	</div>
</div>

<script type="text/javascript">
	function apporder(no_bukti_po){
		$.ajax({
				type: 'POST',
				url : 'approve_bi',
				data: 'no_bukti_po='+no_bukti_po,	
				beforeSend : function() {
				},
				success: function(msg){
					if(msg == 1){
						alert('Pesanan Berhasil Diterima');
						location.reload();
					}
				}
		});
	}
</script>