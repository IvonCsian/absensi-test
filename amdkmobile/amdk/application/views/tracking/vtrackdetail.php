<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$param = array();
			$param['no_bukti_order'] = $no_bukti_order;
			$DataResult = $this->transaksi_model->detailPesanan($param);

			$tgl_order = $this->func_global->dsql_tglfull($DataResult[0]->tgl_order);
			$tgl_app_order = $DataResult[0]->tgl_app_order;
			$tgl_kirim = $DataResult[0]->tgl_kirim;
			$tgl_done = $DataResult[0]->tgl_done;

			$nm_penerima = $DataResult[0]->nm_penerima;
			$hp_penerima = $DataResult[0]->hp_penerima;
			$alamat = $DataResult[0]->alamat_penerima;
			$note = $DataResult[0]->note;

			$nm_agen = $DataResult[0]->nm_agen;
			$alamat_agen = $DataResult[0]->alamat;
			$telp = $DataResult[0]->telp;

			$flag_order = $DataResult[0]->flag_order;
			$flag_kirim = $DataResult[0]->flag_kirim;
			$flag_done = $DataResult[0]->flag_done;

			if($flag_order == 1 && $flag_kirim == 0){
				$status_od = "<span class='btn btn-danger btn-sm'>Menunggu Diproses Agen</span>";
			}
			else if($flag_order == 2 && $flag_kirim == 0){
				$status_od = "<span class='btn btn-info btn-sm'>Diproses Agen</span>";
			}
			else if($flag_order == 2 && $flag_kirim == 1 && $flag_done == 0){
				$status_od = "<span class='btn btn-warning btn-sm'>Pesanan Dikirim</span>";
			}
			else if($flag_done == 1){
				$status_od = "<span class='btn btn-success btn-sm'>Pesanan Diterima</span>";
			}

			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<h5 class='total-price mb-0'>$status_od</h5>
				$no_bukti_order
			</div>";
			echo "</div><p></p>";

			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<font size='2' color='black'>Tracking</font>
			</div>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<table class='table mb-0'>
					<tr>
						<th scope='row'><font size='2'>Agen</font></th>
						<td><font size='2'>$nm_agen / $telp / $alamat_agen</font></td>
					</tr>
					<tr>
						<th scope='row'><font size='2'>Tgl.Diproses Agen</font></th>
						<td><font size='2'>$tgl_app_order</font></td>
					</tr>
					<tr>
						<th scope='row'><font size='2'>Tgl.Kirim</font></th>
						<td><font size='2'>$tgl_kirim</font></td>
					</tr>
					<tr>
						<th scope='row'><font size='2'>Tgl.Diterima</font></th>
						<td><font size='2'>$tgl_done</font></td>
					</tr>
				</table>
			</div>
			</div>";

			// --- tracking ---
			if($flag_order == 2  && $flag_kirim == 1 && $flag_done == 0){
				echo "
				<div class='card cart-amount-area'>
				<div class='card-body d-flex align-items-center justify-content-between'>
					<button class='btn btn-success btn-lg w-100' onclick=terimaorder('$no_bukti_order')>Terima</button>
				</div>
				</div>";
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
						alert('Pesanan Berhasil Diterima,Terima Kasih Telah Berbelanja');
						location.reload();
					}
				}
		});
	}
</script>