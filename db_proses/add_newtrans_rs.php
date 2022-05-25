<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$id=$_COOKIE["idstaff_bill"];

  if (empty($id)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT max(id_restok) as maxKode FROM tb_restok WHERE jenis_restok = 'RESTOK' AND  MONTH(tgl_restok) = MONTH(CURRENT_DATE()) AND YEAR(tgl_restok) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "RST-".date("m")."-".date("y")."-OFF-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);

		$sql = "INSERT INTO tb_restok(id_restok, tgl_restok, total_restok, status_restok, jenis_restok, event_restok, staff_restok, kantor_restok, keterangan_restok) 
						VALUES ('$kode', NOW(), '0', 'PENDING', 'RESTOK', 'OFFICE', '$id', '0', '0')";
		$result = mysqli_query($kon,$sql);	  
		
		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";	
			$status['nota']= $kode;
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
