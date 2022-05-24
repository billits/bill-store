<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - duit e kurang
	
	$staff1=$_COOKIE["idstaff_bill"];
	$jenis = $_POST['jenis'];
	$buy = $_POST['buy'];
	$nama = $_POST['nama'];
	$ntjk = $_POST['ntjk'];
	$tlp = '00';
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];
	$vou = $_POST['Voucher'];
	$dibayar = $_POST['Dibayar'];

  if (empty($nota)||empty($jenis)||empty($buy)||empty($ntjk)||empty($nama)||empty($total)||empty($kantor)||empty($staff)||empty($dibayar)){
		$valid=1;
	}

	$total_final=$total-$vou;
	$kembalian=$dibayar-$total_final;

	$count=0;

	$query2="SELECT * FROM tb_detail_jual_konsi INNER JOIN tb_jual_konsi ON tb_jual_konsi.id_jk=tb_detail_jual_konsi.nota_detjk 
    INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual_konsi.produk_detjk 
    INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_jual_konsi.harga_detjk 
    WHERE tb_jual_konsi.id_jk='$ntjk'";
  $result2 = mysqli_query($kon, $query2);
    
  while($baris2 = mysqli_fetch_assoc($result2)){
    $produk=$baris2['id_produk'];
    $totju=$baris2['total_jk'];
    $totpro=$baris2['qty_detjk'];
    $jml_ret=0;
    $jml_laku=0;      
    $jml_beli=0;   
    $dis_beli=0;
    $tojum_beli=0;

    $query3="SELECT * FROM tb_produk 
    	INNER JOIN tb_detail_retur_transaksi ON tb_detail_retur_transaksi.produk_detrettrans=tb_produk.id_produk 
    	INNER JOIN tb_retur_transaksi ON tb_retur_transaksi.id_retur=tb_detail_retur_transaksi.id_detrettrans
      WHERE tb_detail_retur_transaksi.produk_detrettrans='$produk' AND tb_retur_transaksi.notajual_retur='$ntjk'";
    $result3 = mysqli_query($kon, $query3);
    while($baris3 = mysqli_fetch_assoc($result3)){
      $jml_ret=$jml_ret+$baris3['jumret_detrettrans'];
    }

    $query4="SELECT * FROM tb_produk 
      INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
      INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
      WHERE tb_detail_jual.produk_detjual='$produk' AND tb_jual.acara_jual='OFFICE' AND tb_jual.keterangan_jual='$ntjk'";
    $result4 = mysqli_query($kon, $query4);
    while($baris4 = mysqli_fetch_assoc($result4)){
      $jml_laku=$jml_laku+$baris4['qty_detjual'];
    }

    $query5="SELECT * FROM tb_produk 
    	INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
      INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
      WHERE tb_detail_jual.produk_detjual='$produk' AND tb_jual.id_jual='$nota'";
    $result5 = mysqli_query($kon, $query5);
    while($baris5 = mysqli_fetch_assoc($result5)){
      $jml_beli=$baris5['qty_detjual'];
      $dis_beli=$baris5['diskon_detjual'];
      $tojum_beli=$baris5['total_jumlah_detjual'];
    }

	  $totpro=$totpro-($jml_ret+$jml_laku);

	  if ($totpro!='0'){
		  $count=$count+1;
	  }
	}

	if($total_final>$dibayar){
		$valid=2;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT * FROM tb_jual WHERE id_jual='$nota'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$tgl_order = $rowre['tgl_order_jual'];		

		$sl = "UPDATE tb_jual SET tgl_order_jual='$tgl_order', total_jual='$total_final', tgl_approv_jual=NOW(), cara_bayar_jual='$buy', 
			status_jual='SUCCESS', jenis_jual='$jenis', gudang_jual='$staff1',nama_customer='$nama', tlp_customer='$tlp', checking_by='AUTO', voucher_jual='$vou', dibayar_jual='$dibayar', kembalian_jual='$kembalian' 
			WHERE id_jual='$nota'";
		$reslt = mysqli_query($kon,$sl);

		if(!$reslt) {    
			$cek=$cek+1;
		}

		if ($count=='0'){
			$sqlre1= "SELECT * FROM tb_jual_konsi WHERE id_jk='$ntjk'";
			$resultre1 = mysqli_query($kon,$sqlre1);
			$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
			$tgl_order1 = $rowre1['tgl_order_jk'];		
			$tgl_app = $rowre1['tgl_approv_jk'];		

			$sl2 = "UPDATE tb_jual_konsi SET tgl_order_jk='$tgl_order1', tgl_approv_jk='$tgl_app', retur_jk='1' WHERE id_jk='$ntjk'";
			$reslt2 = mysqli_query($kon,$sl2);

			if(!$reslt2) {    
				$cek=$cek+1;
			}
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['nott']=$nota; 
			$status['error']="Data Transaksi Berhasil Diproses";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Diproses";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
    $status['error']="Total Dibayarkan Kurang, Tidak Dapat Diproses";
	}

	echo json_encode($status);
?>
