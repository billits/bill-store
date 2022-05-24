<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong

	$staff = $_COOKIE['idstaff_bill'];
	$kantor = $_COOKIE['office_bill'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$konsi = $_POST['konsi'];
	$cont = $_POST['cont'];
	$jum=0;
	$total=$_POST['bayar'];

  if (empty($nota)||empty($konsi)){
		$valid=1;
	}
	
	$sqlre1= "SELECT * FROM tb_jual_konsi WHERE id_jk = '$konsi'";
	$resultre1 = mysqli_query($kon,$sqlre1);	  
	$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
	$t_approv=$rowre1['tgl_approv_jk'];
	$t_order=$rowre1['tgl_order_jk'];

	if ($valid==0){
		mysqli_autocommit($kon, false);

		if ($cont!=0){
			$sql="SELECT * FROM tb_detail_retur_transaksi WHERE id_detrettrans='$nota'";
			$ss=mysqli_query($kon,$sql);
			while($data=mysqli_fetch_array($ss)){
				$pro=$data['produk_detrettrans'];
				$jum=$data['jumret_detrettrans'];

				$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
				tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='OFFICE'";
				$resltt = mysqli_query($kon,$sli);
				if(!$resltt) {    
					$cek=$cek+1;
				}
			}

			$sl = "UPDATE tb_retur_transaksi SET waktu_retur=NOW(), total_retur='$total', keterangan_retur='$ketsup' WHERE id_retur='$nota'";
			$reslt = mysqli_query($kon,$sl);
			if(!$reslt) {    
				$cek=$cek+1;
			}

		}else{
			$sql="SELECT * FROM tb_detail_retur_transaksi WHERE id_detrettrans='$nota'";
			$ss=mysqli_query($kon,$sql);
			while($data=mysqli_fetch_array($ss)){
				$pro=$data['produk_detrettrans'];
				$jum=$data['jumret_detrettrans'];

				$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
				tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='OFFICE'";
				$resltt = mysqli_query($kon,$sli);
				if(!$resltt) {    
					$cek=$cek+1;
				}
			}

			$sl = "UPDATE tb_retur_transaksi SET waktu_retur=NOW(), total_retur='$total', keterangan_retur='$ketsup', status_retur='SUCCESS' WHERE id_retur='$nota'";
			$reslt = mysqli_query($kon,$sl);
			if(!$reslt) {    
				$cek=$cek+1;
			}

			$sl2 = "UPDATE tb_jual_konsi SET retur_jk='$nota', tgl_approv_jk='$t_approv', tgl_order_jk='$t_order' WHERE id_jk='$konsi'";
			$reslt2 = mysqli_query($kon,$sl2);
			if(!$reslt2) {    
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
