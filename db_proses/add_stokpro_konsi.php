<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double
	// 3 - stok tidak cukup
	// 4 - stok kosong
	
	$nota = $_POST['nota'];
	$produk = $_POST['kode_produk'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$hh_pro = $_POST['hh_pro'];
	$office = $_COOKIE["office_bill"];
	$staff = $_COOKIE["idstaff_bill"];

  if (empty($nota)||empty($produk)||empty($price)||empty($qty)||empty($hh_pro)){
		$valid=1;
	}

	$tot = $qty*$price;

	$sqlre= "SELECT * FROM tb_detail_po WHERE nota_detpo= '$nota' AND produk_detpo='$produk'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);

	if($countre >= 1) { 
		$valid=2;	         
	}else{
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
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql = "INSERT INTO tb_detail_po(nota_detpo, produk_detpo, harga_detpo, qty_detpo, diskon_detpo, total_jumlah_detpo) 
					VALUES ('$nota', '$produk', '$hh_pro', '$qty', '0', '$tot')";
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
		
		if ($cek==0){
			mysqli_commit($kon);  
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";	
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
		}
	
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Produk Sudah Tersedia"; 
	}elseif($valid==3){
		$status['nilai']=0; //bernilai salah
		$status['error']="Stok Produk di Gudang Tidak Mencukupi";
	}elseif($valid==4){
		$status['nilai']=0; //bernilai salah
		$status['error']="Stok Produk di Gudang Tidak Ada";
	}

	echo json_encode($status);
?>
