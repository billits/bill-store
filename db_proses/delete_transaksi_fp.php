<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$staff = $_COOKIE["idstaff_bill"];
	$office = $_COOKIE['office_bill'];
	$kode_nota= $_REQUEST['kode_nota'];

  if (empty($staff)||empty($office)||empty($kode_nota)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql1= "SELECT * FROM tb_detail_fp 
		INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_fp.produk_detfp 
		INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
		WHERE tb_detail_fp.id_detfp='$kode_nota'";
		$result1 = mysqli_query($kon,$sql1);
		while($baris1 = mysqli_fetch_assoc($result1)){
			$produk=$baris1['produk_detfp'];
			$jum_produk=$baris1['jum_detfp'];

			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum_produk', supplier_gudang='$staff', staff_gudang='$staff', 
				tgl_update_gudang=NOW() WHERE kode_produk_gudang='$produk' AND kode_office_gudang='$office' AND event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);

			if(!$resltt) {    
				$cek=$cek+1;
			}
		}

		$sql11 = "DELETE FROM tb_free_produk WHERE id_fp='$kode_nota'";
  	$result11 = mysqli_query($kon,$sql11);		

  	$sql = "DELETE FROM tb_detail_fp WHERE id_detfp='$kode_nota'";
  	$result = mysqli_query($kon,$sql);
	
		if(!$result11) {    
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
