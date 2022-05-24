<?php
	include "koneksi.php";

	$cek=0;
	$valid=0;
	// 1 - data kosong

	$staff = $_COOKIE["idstaff_bill"];
	$office = $_COOKIE['office_bill'];
	$kode_nota= $_REQUEST['kode_nota'];

  if (empty($kode_nota)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		// $sql1= "SELECT * FROM tb_detail_po 
		// INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_po.produk_detpo 
		// WHERE tb_detail_po.nota_detpo='$kode_nota'";
		// $result1 = mysqli_query($kon,$sql1);
		// while($baris1 = mysqli_fetch_assoc($result1)){
		// 	$produk=$baris1['produk_detpo'];
		// 	$jum_produk=$baris1['qty_detpo'];

		// 	$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum_produk', supplier_gudang='$staff', staff_gudang='$staff', 
		// 					tgl_update_gudang=NOW() WHERE kode_produk_gudang='$produk' AND kode_office_gudang='$office' AND event_gudang='OFFICE'";
		// 	$resltt = mysqli_query($kon,$sli);

		// 	if(!$resltt) {    
		// 		$cek=$cek+1;
		// 	}	
		// }

		$sql2 = "DELETE FROM tb_po WHERE id_po='$kode_nota'";
		$result2 = mysqli_query($kon,$sql2);		

		$sql = "DELETE FROM tb_detail_po WHERE nota_detpo='$kode_nota'";
		$result = mysqli_query($kon,$sql);

		if(!$result2) {    
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
