<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$total = $_POST['total'];
	$nota = $_POST['nota'];
	$staff = $_POST['staff'];
	$kantor = $_POST['kantor'];

  if (empty($staff)||empty($nota)||empty($kantor)||empty($total)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql="SELECT * FROM tb_detail_retur_event WHERE id_detretevt='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){
			$pro=$data['produk_detretevt'];
			$jum=$data['jumret_detretevt'];

			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
			tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='PST' AND event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);
			if(!$resltt) {    
				$cek=$cek+1;
			}
		}	

		$sqlrr = "UPDATE tb_retur_event SET status_returevt='SUCCESS', waktu_returevt=NOW() WHERE id_returevt='$nota'";
		$resltrr = mysqli_query($kon,$sqlrr);

		if(!$resltrr) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Retur Berhasil Di Approve";
			$status['kode_nota']=$nota;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Di Approve";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}	
	echo json_encode($status);
?>
