<?php
	include "koneksi.php";
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double
	
	$nama_pegawai = ucwords(strtolower($_POST['nama_pegawai']));
	$uname_pegawai = $_POST['uname_pegawai'];
	$pwd_pegawai = $_POST['pwd_pegawai'];
	$office_pegawai = $_POST['office_pegawai'];
	$myid = $_COOKIE['idstaff_bill'];
	$countr = 0;

  if (empty($nama_pegawai)||empty($uname_pegawai)||empty($pwd_pegawai)||empty($office_pegawai)){
		$valid=1;
	}
	
	$sqlr= "SELECT * FROM tb_staff WHERE uname_staff='$uname_pegawai'";
	$resultr = mysqli_query($kon,$sqlr);
	$rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
	$countr = mysqli_num_rows($resultr);

	if ($countr>=1){
		$valid=2;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT max(kode_staff) as maxKode FROM tb_staff WHERE office_staff='$office_pegawai'";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 9, 15);
		$noUrut++;
		$kode_temp = "BILL-".$office_pegawai."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);

		$sqlll = "INSERT INTO tb_staff(kode_staff, nama_staff, office_staff, uname_staff, pass_staff, create_staff, active_staff) VALUES 
							('$kode', '$nama_pegawai', '$office_pegawai', '$uname_pegawai', '$pwd_pegawai', '$myid', 'ON')";
		$result = mysqli_query($kon,$sqlll);	  

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Pegawai Berhasil Ditambahkan";
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
		$status['error']="Username Sudah Digunakan";
	}
	echo json_encode($status);
?>
