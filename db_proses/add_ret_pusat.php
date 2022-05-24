<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$kantor = $_COOKIE['office_bill'];    
	$id=$_COOKIE["idstaff_bill"];
		
  if (empty($kantor)||empty($id)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlr= "SELECT max(id_returevt) as maxKode FROM tb_retur_event WHERE event_returevt = 'OFFICE' AND kantor_returevt = '$kantor' AND MONTH(waktu_returevt) = MONTH(CURRENT_DATE()) AND YEAR(waktu_returevt) = YEAR(CURRENT_DATE()) ";
		$resultr = mysqli_query($kon,$sqlr);	  
		$rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
		$countr = mysqli_num_rows($resultr);
				
		$kodeRan = $rowr['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "NTR-".date("m")."-".date("y")."-".$kantor."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);

		$sql = "INSERT INTO tb_retur_event (id_returevt, event_returevt, staff_returevt, waktu_returevt, kantor_returevt, total_returevt, keterangan_returevt, status_returevt) 
			VALUES ('$kode', 'OFFICE', '$id', NOW(), '$kantor', '0', '0', 'PENDING')";
		$result = mysqli_query($kon,$sql);

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Retur Berhasil Ditambahkan";
			$status['nota']=$kode;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
