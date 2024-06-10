<div class="page-content-wrapper">
	<div class="container">
	<div class="cart-wrapper-area py-3">
		<?php 
			$param = array();
			$param['no_bukti_order'] = $no_bukti_order;
			$DataResult = $this->transaksi_model->detailPesanan($param);

			

			$tgl_order = $this->func_global->dsql_tglfull($DataResult[0]->tgl_order);
			$nm_penerima = $DataResult[0]->nm_penerima;
			$hp_penerima = $DataResult[0]->hp_penerima;
			$alamat = $DataResult[0]->alamat_penerima;
			$note = $DataResult[0]->note;

			$nm_agen = $DataResult[0]->nm_agen;
			$alamat_agen = $DataResult[0]->alamat;
			$telp = $DataResult[0]->telp;

			$flag_order = $DataResult[0]->flag_order;
			$flag_done = $DataResult[0]->flag_done;
			$flag_kirim = $DataResult[0]->flag_kirim;

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
				$status_od = "<span class='btn btn-success btn-sm'>Pesanan Selesai</span>";
			}

			echo "
			<div class='card cart-amount-area'>
			$status_od
			<div class='card-body d-flex align-items-center justify-content-between'>
				<font size='2'>$no_bukti_order<br>Tanggal Pemesanan $tgl_order</font>
			</div>";
			echo "</div><p></p>";

			// --- data barang ---
			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<font size='2' color='black'>Detail Produk</font>
			</div>";
			
			$DataResultdtl = $this->transaksi_model->dataPesanan($param);

			echo "
			<div class='table-responsive card-body'>
			<table class='table mb-0'>";
				foreach ($DataResultdtl as $key => $dt) {
					$nm_barang = $dt->nm_barang;
					$kd_barang = $dt->kd_barang; 
					$hrg_satuan = $dt->hrg_satuan; 
					$kuantum = $dt->kuantum; 

					echo "<tr>
						<td>".$nm_barang."</td>
						<td align='right'>Qty : ".$kuantum."</td>
					</tr>";
				}
				echo "</table>";
			echo "
			</div>
			</div><p></p>";

			// --- info pengiriman ---
			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<font size='2' color='black'>Info Pengiriman</font>
			</div>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<table class='table mb-0'>
					<tr>
						<th scope='row'><font size='3'>Alamat</font></th>
						<td><font size='2'>$nm_penerima<br>$hp_penerima<br>$alamat<br>$note</font></td>
						<td></td>
					</tr>
				</table>
			</div>
			</div><p></p>";

			// --- info agen kirim ---
			echo "
			<div class='card cart-amount-area'>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<font size='2' color='black'>Info Agen</font>
			</div>
			<div class='card-body d-flex align-items-center justify-content-between'>
				<table class='table mb-0'>
					<tr>
						<th scope='row'><font size='3'>Agen</font></th>
						<td><font size='2'>$nm_agen<br>$telp<br>$alamat_agen</font></td>
						<td></td>
					</tr>
				</table>
			</div>
			</div>";
			
			// --- tracking ---
			if($flag_order == 2){
				echo "
				<div class='card cart-amount-area'>
				<div class='card-body d-flex align-items-center justify-content-between'>
					<button class='btn btn-info btn-lg w-100' onclick=tracking('$no_bukti_order')>Tracking</button>
				</div>
				</div>";
			}
		?>
	</div>
	</div>
</div>
<script type="text/javascript">
	function tracking(no_bukti_order){
		window.location.href='<?php echo base_url(); ?>index.php/tracking/vtrackingdetail?no_trans='+no_bukti_order;
	}
</script>