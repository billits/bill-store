<?php
	include "koneksi.php";	
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$staff = $_COOKIE["idstaff_bill"];
	$office = $_COOKIE['office_bill'];
	$nota= $_REQUEST['kode_nota'];
	$produk= $_REQUEST['kode_produk'];
	$jum_produk= $_REQUEST['jum_produk'];

	if (empty($staff)||empty($office)||empty($nota)||empty($produk)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
	
  	$sql = "DELETE FROM tb_detail_mankonsi where nota_detmk='$nota' and produk_detmk='$produk'";
		$result = mysqli_query($kon,$sql);

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
