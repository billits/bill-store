<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$kode_produk = strtoupper($_POST['kode_produk']);
	$nama_produk = $_POST['nama_produk'];
	$kategori_produk = ucwords(strtolower($_POST['kategori_produk']));

	$staff = $_COOKIE["idstaff_bill"];

	$cek=0;
	$valid=0;
	// 1 - error data kosong
	// 2 - error data double

  if (empty($kode_produk)||empty($nama_produk)||empty($kategori_produk)){
		$valid=1;
	}
	
	$sqlre= "SELECT * FROM tb_produk WHERE id_produk= '$kode_produk'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
      
	if($countre >= 1) {				     
		$valid=2;     
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlll = "INSERT INTO tb_produk(id_produk, nama_produk, kategori_produk) VALUES ('$kode_produk', '$nama_produk', '$kategori_produk')";
		$result = mysqli_query($kon,$sqlll);	

		if (!$result) {
			$cek=$cek+1;
		}
		$sql = "INSERT INTO tb_gudang (kode_produk_gudang, kode_office_gudang, jml_produk_gudang, supplier_gudang, staff_gudang, tgl_update_gudang, event_gudang) 
		SELECT '$kode_produk', off.id_office, '0', '$staff', '$staff', NOW(), 'OFFICE'
		FROM tb_office off";
		$rest = mysqli_query($kon,$sql);

		if (!$rest) {
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";
		}else{
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai benar
			$status['error']="Data Gagal Ditambahkan";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="ID Produk Sudah Ada";
	}
	echo json_encode($status);
?>
