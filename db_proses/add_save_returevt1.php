<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$staff = $_COOKIE['idstaff_bill'];
	$kantor = $_COOKIE['office_bill'];
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$evnt = $_POST['evnt'];
	$cont = $_POST['cont'];
	$jum=0;

  if (empty($ketsup)||empty($nota)||empty($total)||empty($evnt)||empty($staff)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		if ($cont!=0){
			//gakusah insert notif retur
			$sql="SELECT * FROM tb_detail_retur_event WHERE id_detretevt='$nota'";
			$ss=mysqli_query($kon,$sql);
			while($data=mysqli_fetch_array($ss)){
				$pro=$data['produk_detretevt'];
				$jum=$data['jumret_detretevt'];

				$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
				tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='OFFICE'";
				$resltt = mysqli_query($kon,$sli);
				if(!$resltt) {    
					$cek=$cek+1;
				}
			}

			$sl = "UPDATE tb_retur_event SET waktu_returevt=NOW(), total_returevt='$total', status_returevt='SUCCESS', keterangan_returevt='$ketsup' WHERE id_returevt='$nota'";
			$reslt = mysqli_query($kon,$sl);
			if(!$reslt) {    
				$cek=$cek+1;
			}
		//insert notif retur krena sudah selesai retur semua
		}else {
			$sql="SELECT * FROM tb_detail_retur_event WHERE id_detretevt='$nota'";
			$ss=mysqli_query($kon,$sql);
			while($data=mysqli_fetch_array($ss)){
				$pro=$data['produk_detretevt'];
				$jum=$data['jumret_detretevt'];

				$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
				tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='OFFICE'";
				$resltt = mysqli_query($kon,$sli);
				if(!$resltt) {    
					$cek=$cek+1;
				}
			}

			$sl = "UPDATE tb_retur_event SET waktu_returevt=NOW(), total_returevt='$total', status_returevt='SUCCESS', keterangan_returevt='$ketsup' WHERE id_returevt='$nota'";
			$reslt = mysqli_query($kon,$sl);
			if(!$reslt) {    
				$cek=$cek+1;
			}

			$sqlll = "INSERT INTO tb_notif_retur(event_retur, status_retur, waktu_retur, staff_retur) VALUES ('$evnt', '1', NOW(), '$staff')";
			$result = mysqli_query($kon,$sqlll);	
			if(!$result) {    
				$cek=$cek+1;
			}
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['nott']=$nota; 
			$status['error']="Data Retur Berhasil Diproses";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Diproses";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
