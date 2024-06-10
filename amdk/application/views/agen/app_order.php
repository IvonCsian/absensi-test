<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$DataOrder = $this->terima_model->cekPesanan();
			if($DataOrder > 0){ 
				$DataResult = $this->terima_model->jmPesanan();
				foreach ($DataResult as $key => $value) {
					$username = $this->session->userdata('username');
					$no_bukti_order = $value->no_bukti_order; 
					$nm_penerima = $value->nm_penerima; 
					$hp = $value->hp_penerima; 
					$note = $value->note; 
					$alamat = $value->alamat_penerima; 
					$flag_order = $value->flag_order; 
					$flag_kirim = $value->flag_kirim; 

					// --- cek stok ---
					$qstok = "SELECT m.*,SUM(flag_od=0) AS dt FROM (SELECT a.*,b.kd_barang,b.kuantum,c.stok_barang,IF(c.stok_barang > b.kuantum,1,0) AS flag_od FROM t_checkout a 
					LEFT JOIN t_checkout_dtl b ON a.no_bukti_order = b.no_bukti_order 
					LEFT JOIN (SELECT * FROM t_stok_barang WHERE kd_agen = '$username') c ON b.kd_barang = c.kd_barang
					WHERE a.flag_order <> 0 AND a.flag_done = 0 AND a.no_bukti_order = '$no_bukti_order' ORDER BY a.tgl_input ASC) m";
					$rstok = $this->db->query($qstok)->result();
					$dt_stok = $rstok[0]->dt;
					
					if($dt_stok == 0){ // --- jika stok ready ---

					if($flag_order == 1 && $flag_kirim == 0){
						$status_od = "<button class='btn btn-warning btn-lg w-100' onclick=apporder('$no_bukti_order')>Terima Pesanan</button>";
					}
					else if($flag_order == 2 && $flag_kirim == 0){
						$status_od = "<button class='btn btn-info btn-lg w-100' onclick=kirimorder('$no_bukti_order')>Kirim Pesanan</button>";
					}
					else if($flag_order == 2 && $flag_kirim == 1){
						$status_od = "Mununggu Pesanan Diterima Pelanggan";
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
								<td>Info Pengiriman</td>
							</tr>
							<tr>
								<td><font style='color:black' size='2'>$nm_penerima<br>$hp<br>$alamat<br>$note</font></td>
							</tr>
						</table>
					</div>
					</div>

					<div class='cart-table card mb-3'>
					<div class='table-responsive card-body'>";

					$param = array();
					$param['no_bukti_order'] = $no_bukti_order;
					$DataResultdtl = $this->terima_model->dataPesanan($param);

					echo "<table class='table mb-0'>
					<tbody>
					<tr>
						<td colspan='2'><font style='color:red' size='2'><b>Data Order</b></font></td>
					<tr>";

					foreach ($DataResultdtl as $key => $dt) {
						$nm_barang = $dt->nm_barang;
						$kd_barang = $dt->kd_barang; 
						$hrg_satuan = $dt->hrg_satuan; 
						$kuantum = $dt->kuantum; 

						echo "
						<tr>
							<td><font style='color:black' size='2'>".$nm_barang."</font></td>
							<td><font style='color:black' size='2'>".$kuantum."</font></td>
						</tr>";
					}
					echo "</tbody></table>
					</div>
					</div>";

					echo "
					<div class='card-body d-flex align-items-center center-content-between'>
						$status_od
					</div>
					</div><p></p>";
					}
				}
			}
		?>
	</div>
	</div>
</div>

<script type="text/javascript">
	function apporder(no_bukti_order){
		$.ajax({
				type: 'POST',
				url : 'approve_order',
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

	function kirimorder(no_bukti_order){
		$.ajax({
				type: 'POST',
				url : 'kirim_order',
				data: 'no_bukti_order='+no_bukti_order,	
				beforeSend : function() {
				},
				success: function(msg){
					if(msg == 1){
						alert('Pesanan Berhasil Dikirim');
						location.reload();
					}
				}
		});
	}
</script>