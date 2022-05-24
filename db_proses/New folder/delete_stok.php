<?php
	include "koneksi.php";
	$kode_nota= $_REQUEST['kode_nota'];

	$sql1 = "DELETE FROM beli where id_beli='$kode_nota'";
  $result1 = mysqli_query($kon,$sql1);		

  $sql = "DELETE FROM detail_beli where nota_detbeli='$kode_nota'";
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
