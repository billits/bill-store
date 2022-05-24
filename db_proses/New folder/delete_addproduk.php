<?php
	include "koneksi.php";
	$nota= $_REQUEST['kode_nota'];
	$produk= $_REQUEST['kode_produk'];
	
  	$sql = "DELETE FROM detail_beli where nota_detbeli='$nota' and produk_detbeli='$produk'";
	$result = mysqli_query($kon,$sql);
	
	if($result) {        
		$status['nilai']=1; //bernilai benar
		$status['error']="Data Berhasil Dihapus";
	}else{     
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Gagal Dihapus";
	} 
	echo json_encode($status);
?>
