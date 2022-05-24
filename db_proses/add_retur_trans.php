<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$staff = $_COOKIE['idstaff_bill'];
	$kantor = $_COOKIE['office_bill'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$ntj = $_POST['ntj'];
	$jum=0;
	$bayar=0;
		
  if (empty($kantor)||empty($staff)||empty($nota)||empty($ntj)||empty($ketsup)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
	  
	  $query="SELECT * FROM tb_detail_jual INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual 
    INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual.produk_detjual 
    INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
    INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_jual.harga_detjual 
    WHERE tb_jual.id_jual='$ntj'";
    $result = mysqli_query($kon, $query);
    while($baris = mysqli_fetch_assoc($result)){
      $bayar=$bayar+$baris['total_jumlah_detjual'];
      $produk=$baris['id_produk'];
      $maks_ret=$baris['qty_detjual'];
      $pc=$baris['harga_detjual'];
      $subtotal=$baris['total_jumlah_detjual'];
		
      $query4 = "INSERT INTO tb_detail_retur_transaksi(id_detrettrans, produk_detrettrans, jumret_detrettrans, harga_detrettrans, totjum_detrettrans) 
        VALUES ('$nota', '$produk', '$maks_ret', '$pc', '$subtotal')";
      $result4 = mysqli_query($kon,$query4);
      if(!$result4) {    
        $cek=$cek+1;
      }
	  }

    $sl = "UPDATE tb_retur_transaksi SET waktu_retur=NOW(), total_retur='$bayar', keterangan_retur='$ketsup' WHERE id_retur='$nota'";
    $reslt = mysqli_query($kon,$sl);	
	  
		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
      $status['nott']=$nota; 
      $status['error']="Data Retur Berhasil Diproses";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Diproses";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
