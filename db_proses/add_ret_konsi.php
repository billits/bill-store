<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double
	
	$kantor = $_COOKIE['office_bill'];    
	$id=$_COOKIE["idstaff_bill"];
	$konsi = $_POST['konsi'];
		
  if (empty($kantor)||empty($id)||empty($konsi)){
		$valid=1;
	}

	$sqlre= "SELECT * FROM tb_jual_konsi WHERE id_jk='$konsi' AND retur_jk!='0'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
		
	if($countre >= 1) {  			
		$valid=2;
	}


	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlr= "SELECT max(id_retur) as maxKode FROM tb_retur_transaksi 
		WHERE event_retur = 'OFFICE' AND kantor_retur = '$kantor' AND jenis_retur='KONSI'
		AND MONTH(waktu_retur) = MONTH(CURRENT_DATE()) AND YEAR(waktu_retur) = YEAR(CURRENT_DATE()) ";
		$resultr = mysqli_query($kon,$sqlr);	  
		$rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
		$countr = mysqli_num_rows($resultr);
			
		$kodeRan = $rowr['maxKode'];
		$noUrut = (int) substr($kodeRan, 14, 20);
		$noUrut++;
		$kode_temp = "NTR-".date("m")."-".date("y")."-".$kantor."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);

		$sql = "INSERT INTO tb_retur_transaksi (id_retur, event_retur, staff_retur, waktu_retur, 
		kantor_retur, total_retur, keterangan_retur, status_retur, jenis_retur, notajual_retur) 
		VALUES ('$kode', 'OFFICE', '$id', NOW(), '$kantor', '0', '0', 'PENDING', 'KONSI', '$konsi')";
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
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Event Sudah Di Retur";
	}


	echo json_encode($status);
?>
