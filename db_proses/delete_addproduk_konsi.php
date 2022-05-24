<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong

	$office = $_COOKIE["office_bill"];
	$staff = $_COOKIE["idstaff_bill"];
	$nota= $_REQUEST['kode_nota'];
	$produk= $_REQUEST['kode_produk'];

  if (empty($nota)||empty($produk)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql1= "SELECT * FROM tb_detail_po WHERE nota_detpo='$nota' AND produk_detpo='$produk'";
		$result1 = mysqli_query($kon,$sql1);
		$rowre = mysqli_fetch_array($result1,MYSQLI_ASSOC);
		$jum_produk=$rowre['qty_detpo'];

		$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum_produk', supplier_gudang='$staff', staff_gudang='$staff', 
			tgl_update_gudang=NOW() WHERE kode_produk_gudang='$produk' AND kode_office_gudang='$office' AND event_gudang='OFFICE'";
		$resltt = mysqli_query($kon,$sli);

		if(!$resltt) {    
			$cek=$cek+1;
		}

		$sql = "DELETE FROM tb_detail_po where nota_detpo='$nota' and produk_detpo='$produk'";
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
