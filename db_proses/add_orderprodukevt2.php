<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	$cek=0;

	$valid=0;
	// 1 - data kosong
	
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];
	$acara = $_POST['event'];

  if (empty($nota)||empty($total)||empty($ketsup)||empty($kantor)||empty($kantor)||empty($acara)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		$sql="SELECT * FROM tb_detail_beli_event WHERE nota_detbelev='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){
			$pro=$data['produk_detbelev'];
			$jum=$data['qty_detbelev'];

			$sql2= "SELECT * FROM tb_gudang WHERE kode_office_gudang='$kantor' AND kode_produk_gudang='$pro' AND event_gudang ='OFFICE'";
			$ss2 = mysqli_query($kon,$sql2);
			$data2 = mysqli_fetch_array($ss2,MYSQLI_ASSOC);
			$batas_jum = $data2['jml_produk_gudang'];

			if($batas_jum < $jum){
				$cek=$cek+1;
			}else{
				$sqlre= "SELECT * FROM tb_gudang WHERE kode_office_gudang='$kantor' AND kode_produk_gudang='$pro' AND event_gudang ='$acara'";
				$resultre = mysqli_query($kon,$sqlre);
				$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
				$countre = mysqli_num_rows($resultre);
				
				if($countre == 1) {  
					$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' and kode_office_gudang='$kantor' and event_gudang='$acara'";
					$resltt = mysqli_query($kon,$sli);	
					if(!$resltt) {    
						$cek=$cek+1;
					}
					$sli1 = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang-'$jum', supplier_gudang='$staff', staff_gudang='$staff', tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' and kode_office_gudang='$kantor' and event_gudang='OFFICE'";
					$resltt1 = mysqli_query($kon,$sli1);
					if(!$resltt1) {    
						$cek=$cek+1;
					}
				}
				else{
					$squl = "INSERT INTO tb_gudang (kode_produk_gudang, kode_office_gudang, jml_produk_gudang, supplier_gudang, staff_gudang, tgl_update_gudang, event_gudang) VALUES 
					('$pro', '$kantor', '$jum', '$staff', '$staff', NOW(), '$acara')";
					$resuult = mysqli_query($kon,$squl);
					if(!$resuult) {    
						$cek=$cek+1;
					}
					$squl1 = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang-'$jum', supplier_gudang='$staff', staff_gudang='$staff', tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' and kode_office_gudang='$kantor' and event_gudang='OFFICE'";
					$resuult1 = mysqli_query($kon,$squl1);
					if(!$resuult1) {    
						$cek=$cek+1;
					}
				}
			}
		}

		$sl = "UPDATE tb_beli_event SET total_beli_event='$total', stat_beli_event='APPROVE', tgl_beli_event=NOW(), keterangan_beli_event='$ketsup' WHERE id_beli_event='$nota'";
		$reslt = mysqli_query($kon,$sl);

		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);  
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Order Berhasil Ditambahkan di Gudang Event";
			$status['kode_nota']=$nota;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Data Tidak Boleh Kosong";
	}

	echo json_encode($status);
?>
