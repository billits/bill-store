<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong

	$nota= $_REQUEST['kode_nota'];
	$produk= $_REQUEST['kode_produk'];
	$jum= $_REQUEST['kode_jum'];

  if (empty($nota)||empty($produk)||empty($jum)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT * FROM tb_beli_event WHERE id_beli_event = '$nota'";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		
		$totjum=$rowre['total_beli_event'];
		$tgl=$rowre['tgl_beli_event'];
		$fix_jum=$totjum - $jum;

		$sqll = "UPDATE tb_beli_event SET tgl_beli_event='$tgl', total_beli_event='$fix_jum' WHERE id_beli_event='$nota'";
		$res = mysqli_query($kon,$sqll);

		$sql = "DELETE FROM tb_detail_beli_event WHERE nota_detbelev='$nota' AND produk_detbelev='$produk'";
		$result = mysqli_query($kon,$sql);
	
		if(!$res) {    
			$cek=$cek+1;
		}
		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon); 
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Dihapus";
		}else{     
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Dihapus";
		} 
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
