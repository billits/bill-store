<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$id=$_COOKIE["idstaff_bill"];
	$off=$_COOKIE["office_bill"];
	$event = $_REQUEST['event_id'];
	$jenis_evt = $_REQUEST['event_jenis'];

  if (empty($id)||empty($off)||empty($event)||empty($jenis_evt)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT max(tb_man_trans.id_mt) as maxKode FROM tb_man_trans 
		INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_man_trans.acara_mt
		INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
		WHERE tb_man_trans.kantor_mt = '$off' AND tb_detail_events.event_det_event='$jenis_evt' AND tb_detail_events.status_det_event='ON'
		AND MONTH(tb_man_trans.tgl_order_mt) = MONTH(CURRENT_DATE()) AND YEAR(tb_man_trans.tgl_order_mt) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 18, 24);
		$noUrut++;
		$kode_temp = "MNJ-".$jenis_evt."-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
	
		$sql = "INSERT INTO tb_man_trans
		(id_mt, tgl_order_mt, acara_mt, total_mt, cara_bayar_mt, status_mt, tgl_approv_mt, counter_mt, gudang_mt, keterangan_mt, jenis_mt, cs_mt, tlp_mt, checking_mt, kantor_mt, voucher_mt, dibayar_mt, kembalian_mt, manual_mt) 
		VALUES ('$kode', NOW(), '$event', '0', '0', 'PENDING', NOW(), '$id', '0', '0', '0', '0', '0', '0', '$off', '0', '0', '0', '0')";
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
