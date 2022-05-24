<?php
	include "koneksi.php";

	$kode_nota= $_REQUEST['kode_nota'];

	if ($valid==0){
		mysqli_autocommit($kon, false);
		$sql1 = "DELETE FROM tb_beli_event where id_beli_event='$kode_nota'";
		$result1 = mysqli_query($kon,$sql1);		

		$sql = "DELETE FROM tb_detail_beli_event where nota_detbelev='$kode_nota'";
		$result = mysqli_query($kon,$sql);

		if(!$result1) {    
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
