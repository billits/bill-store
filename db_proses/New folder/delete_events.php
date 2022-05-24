<?php
	include "koneksi.php";
	$id= $_REQUEST['delete'];;
	
  	$sql = "DELETE FROM events where id_events='$id'";
	$result = mysqli_query($kon,$sql);
	
	if($result) {        
		$status['nilai']=1; //bernilai benar
		$status['error']="Data Berhasil Ditambah";
	}else{     
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Gagal Ditambah";
	} 
	echo json_encode($status);
?>
