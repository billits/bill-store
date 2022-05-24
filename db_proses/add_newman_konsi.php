<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$id=$_COOKIE["idstaff_bill"];
	$off=$_COOKIE["office_bill"];

  if (empty($id)||empty($off)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sqlre= "SELECT max(tb_man_konsi.id_mk) as maxKode FROM tb_man_konsi WHERE kantor_mk = '$off' AND MONTH(tgl_order_mk) = MONTH(CURRENT_DATE()) AND YEAR(tgl_order_mk) = YEAR(CURRENT_DATE()) ";
		$resultre = mysqli_query($kon,$sqlre);	  
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		$kodeRan = $rowre['maxKode'];
		$noUrut = (int) substr($kodeRan, 15, 21);
		$noUrut++;
		$kode_temp = "MNJK-".date("m")."-".date("y")."-".$off."-";
		$kode = $kode_temp . sprintf("%05s", $noUrut);
		
		$sql = "INSERT INTO tb_man_konsi
		(id_mk, tgl_order_mk, total_mk, cara_bayar_mk, status_mk, tgl_approv_mk, counter_mk, gudang_mk, keterangan_mk, jenis_mk, cs_mk, checking_mk, kantor_mk, voucher_mk, dibayar_mk, kembalian_mk, manual_mk) 
		VALUES ('$kode', NOW(), '0', 'KONSI', 'PENDING', NOW(), '$id', '0', '0', 'KONSI LEADER', '0', '0', '$off', '0', '0', '0', '0')";
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
