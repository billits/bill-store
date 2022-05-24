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

		$sql3= "SELECT * FROM tb_detail_jual_konsi 
		INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual_konsi.produk_detjk 
		INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
		WHERE tb_detail_jual_konsi.nota_detjk='$kode_nota'";
		$result3 = mysqli_query($kon,$sql3);
		while($baris3 = mysqli_fetch_assoc($result3)){
			$produk=$baris3['produk_detjk'];
			$jum_produk=$baris3['qty_detjk'];
			$kategori=$baris3['id_kategori'];

			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum_produk', supplier_gudang='$staff', staff_gudang='$staff', 
				tgl_update_gudang=NOW() WHERE kode_produk_gudang='$produk' AND kode_office_gudang='$office' AND event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);
			if(!$resltt) {    
				$cek=$cek+1;
			}
		}

		$sql1 = "DELETE FROM tb_jual_konsi WHERE id_jk='$kode_nota'";
  	$result1 = mysqli_query($kon,$sql1);		

  	$sql = "DELETE FROM tb_detail_jual_konsi WHERE nota_detjk='$kode_nota'";
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
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
