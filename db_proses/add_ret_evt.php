<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	// 2 - id double
	
	$event = $_POST['event'];  
	$id=$_COOKIE["idstaff_bill"];

  if (empty($event)||empty($id)){
		$valid=1;
	}

	$sqlre= "SELECT * FROM tb_notif_retur WHERE event_retur='$event' AND status_retur='1'";
	$resultre = mysqli_query($kon,$sqlre);
	$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
	$countre = mysqli_num_rows($resultre);
		
	if($countre >= 1) {  			
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre1= "SELECT * FROM tb_detail_events WHERE id_det_event = '$event'";
		$resultre1 = mysqli_query($kon,$sqlre1);	  
		$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
		$event_det = $rowre1['event_det_event'];
		$det_evt = $rowre1['event_det_event'];
		$kantor2 = $rowre1['office_det_event'];

		$sqlr= "SELECT max(tb_retur_event.id_returevt) as maxKode FROM tb_retur_event 
		INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_retur_event.event_returevt
		INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
		WHERE tb_detail_events.event_det_event = '$det_evt' AND tb_retur_event.kantor_returevt = '$kantor2' AND MONTH(tb_retur_event.waktu_returevt) = MONTH(CURRENT_DATE()) AND YEAR(tb_retur_event.waktu_returevt) = YEAR(CURRENT_DATE()) ";
		$resultr = mysqli_query($kon,$sqlr);	  
		$rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
		$countr = mysqli_num_rows($resultr);
		
		$kodeRan = $rowr['maxKode'];
		$noUrut = (int) substr($kodeRan, 18, 24);
		$noUrut++;
		$kode_temp = "NTR-".$event_det."-".date("m")."-".date("y")."-".$kantor2."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);

		$sql = "INSERT INTO tb_retur_event 
		(id_returevt, event_returevt, staff_returevt, waktu_returevt, kantor_returevt, total_returevt, keterangan_returevt, status_returevt) 
		VALUES ('$kode', '$event', '$id', NOW(), '$kantor2', '0', '0', 'PENDING')";
		$result = mysqli_query($kon,$sql);	  

		if(!$result) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Retur Berhasil Ditambahkan";
			$status['nota_id']=$kode;
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
