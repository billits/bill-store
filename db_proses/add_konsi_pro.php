<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	$act=0;
	// 1 - data kosong
	// 2 - id double di list
	// 3 - stok tidak cukup
	// 4 - stok kosong

	$staff = $_COOKIE["idstaff_bill"];
	$nota = $_POST['nota'];
	$produk = $_POST['kode_produk'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$hh_pro = $_POST['hh_pro'];
	$office = $_POST['office'];
	$diskon = $_POST['diskon'];
	$kategori = $_POST['cate'];

  if (empty($staff)||empty($nota)||empty($produk)||empty($price)||empty($qty)||empty($hh_pro)||empty($office)||empty($kategori)){
		$valid=1;
	}

	$hrg_diskon=$diskon;
	$hrg_pdk=$price-$hrg_diskon;
	$tot = $qty*$hrg_pdk;  

	$sqlre1= "SELECT * FROM tb_detail_jual_konsi WHERE nota_detjk='$nota' AND produk_detjk='$produk'";
  $resultre1 = mysqli_query($kon,$sqlre1);
	$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
  $countre1 = mysqli_num_rows($resultre1);

  if($countre1 < 1) {  
		$sqlre= "SELECT * FROM tb_gudang WHERE kode_office_gudang='$office' AND kode_produk_gudang='$produk' AND event_gudang='OFFICE'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		$temp = $rowre['jml_produk_gudang'];
		if($countre == 1) {  
			if($temp >= $qty){
				$act=2;
			}else{
				$valid=3;	
			}
		}else{   		
			$valid=4;	
		}
	}else{		
		$valid=2;	    
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		if ($act==2){
			$sql = "INSERT INTO tb_detail_jual_konsi(nota_detjk, produk_detjk, harga_detjk, qty_detjk, diskon_detjk, totjum_detjk) VALUES 
			('$nota', '$produk', '$hh_pro', '$qty', '$diskon', '$tot')";
			$result = mysqli_query($kon,$sql);	  

			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang-'$qty', supplier_gudang='$staff', staff_gudang='$staff', 
			tgl_update_gudang=NOW() WHERE kode_produk_gudang='$produk' AND kode_office_gudang='$office' AND event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);

			if(!$result) {    
				$cek=$cek+1;
			}
			if(!$resltt) {    
				$cek=$cek+1;
			}
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data  Berhasil Ditambahkan";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Sudah Ada di List";
	}elseif($valid==3){
		$status['nilai']=0; //bernilai salah
		$status['error']="Stok Produk di Gudang Tidak Mencukupi";
	}elseif($valid==4){
		$status['nilai']=0; //bernilai salah
		$status['error']="Stok Produk di Gudang Tidak Ada";
	}
	
	echo json_encode($status);
?>
