<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$DataOrder = $this->pesanan_model->cekPesanan();
			if($DataOrder > 0){ 
				$DataResult = $this->pesanan_model->jmPesanan();
				foreach ($DataResult as $key => $value) {
					$no_bukti_order = $value->no_bukti_order; 
					$nm_penerima = $value->nm_penerima; 
					$hp = $value->hp_penerima; 
					$nm_agen = $value->nm_agen; 
					$alamat = $value->alamat_penerima; 
					$flag_order = $value->flag_order; 
					$flag_kirim = $value->flag_kirim; 

					if($flag_order == 1 && $flag_kirim == 0){
						$status_od = "Menunggu Diproses Agen";
						$btn_terima ="";
					}
					else if($flag_order == 2 && $flag_kirim == 0){
						$status_od = "Pesanan Diproses ".$nm_agen;
						$btn_terima ="";
					}
					else if($flag_order == 2 && $flag_kirim == 1){
						$status_od = "Pesanan Dikirim ".$nm_agen;

						$btn_terima = "<button class='btn btn-success btn-lg w-100' onclick=terimaorder('$no_bukti_order')>Pesanan Diterima</button>";
					}

					echo "
					<div class='card cart-amount-area'>
					<div class='card-body d-flex align-items-center justify-content-between'>
						<h7 class='total-price mb-0'><font style='color:black'>No.Order</font></h7>
						<h7 class='total-price mb-0'><font style='color:black'>$no_bukti_order</font></h7>
					</div>

					<div class='cart-table card mb-3'>
					<div class='table-responsive card-body'>
						<table class='table mb-0'>
							<tr>
								<td>$nm_penerima<br>$hp<br>$alamat</td>
							</tr>
						</table>
					</div>
					</div>

					<div class='cart-table card mb-3'>
					<div class='table-responsive card-body'>";

					$param = array();
					$param['no_bukti_order'] = $no_bukti_order;
					$DataResultdtl = $this->pesanan_model->dataPesanan($param);

					echo "<table class='table mb-0'>
					<tbody>
					<tr>
						<td colspan='2'><font style='color:red'><b>Data Order</b></font></td>
					<tr>";

					foreach ($DataResultdtl as $key => $dt) {
						$nm_barang = $dt->nm_barang;
						$kd_barang = $dt->kd_barang; 
						$hrg_satuan = $dt->hrg_satuan; 
						$kuantum = $dt->kuantum; 

						echo "<tr>
							<td>".$nm_barang."</td>
							<td>".$kuantum."</td>
						</tr>";
					}
					echo "</tbody></table>
					</div>
					</div>";

					echo "
					<div class='card-body d-flex align-items-center center-content-between'>
						<h8 class='total-price mb-0'><font style='color:blue'>$status_od</font>$btn_terima</h8>
					</div>
					</div><p></p>";
				}
			}
		?>
	</div>
	</div>
</div>
<script type="text/javascript">
	function terimaorder(no_bukti_order){
		$.ajax({
				type: 'POST',
				url : 'terima_order',
				data: 'no_bukti_order='+no_bukti_order,	
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