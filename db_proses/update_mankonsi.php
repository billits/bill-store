<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');

	$cek=0;
	$valid=0;
	// 1 - DATA KOSONG
	// 2 - STOK TIDAK CUKUP
	
	$id=$_COOKIE["idstaff_bill"];
	$off=$_COOKIE["office_bill"];
	$ntj = $_POST['ntj'];

	$istok = 0;
	$kapasitas=0;

  if (empty($id)||empty($ntj)||empty($off)){
		$valid=1;
	}
	
	$sql1= "SELECT * FROM tb_man_konsi WHERE id_mk = '$ntj'";
	$result1 = mysqli_query($kon,$sql1);	  
	$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

	$t_order=$row1['tgl_order_mk'];
	$t_total=$row1['total_mk'];
	$t_cara=$row1['cara_bayar_mk'];
	$t_status_j=$row1['status_mk'];
	$t_approv=$row1['tgl_approv_mk'];
	$t_counter=$row1['counter_mk'];
	$t_gudang=$row1['gudang_mk'];
	$t_ket=$row1['keterangan_mk'];
	$t_jenis=$row1['jenis_mk'];
	$t_cs=$row1['cs_mk'];
	$t_kantor=$row1['kantor_mk'];


	//PEMBUATAN KODE NTJ KONSI
	$sqlre2= "SELECT max(tb_jual_konsi.id_jk) as maxKode FROM tb_jual_konsi WHERE kantor_jk = '$off' 
	AND MONTH(tgl_order_jk) = MONTH(CURRENT_DATE()) AND YEAR(tgl_order_jk) = YEAR(CURRENT_DATE()) ";
	$resultre2 = mysqli_query($kon,$sqlre2);	  
	$rowre2 = mysqli_fetch_array($resultre2,MYSQLI_ASSOC);
	$countre2 = mysqli_num_rows($resultre2);
	$kodeRan = $rowre2['maxKode'];
	$noUrut = (int) substr($kodeRan, 15, 21);
	$noUrut++;
	$kode_temp = "NTJK-".date("m")."-".date("y")."-".$off."-";
	$kode = $kode_temp . sprintf("%05s", $noUrut);

	//PENGECEKKAN KAPASITAS
	$kapasitas=0;
		
	$sqlc1="SELECT * FROM tb_detail_mankonsi 
		INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_mankonsi.produk_detmk 
		INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk WHERE tb_detail_mankonsi.nota_detmk='$ntj'";
	$ssc1=mysqli_query($kon,$sqlc1);
	while($rowc1=mysqli_fetch_array($ssc1)){
		$prod=$rowc1['produk_detmk'];
		$jum=$rowc1['qty_detmk'];
		
			$sqlc2= "SELECT * FROM tb_gudang WHERE kode_office_gudang='$off' AND kode_produk_gudang='$prod' AND event_gudang='OFFICE'";
			$ssc2 = mysqli_query($kon,$sqlc2);
			$rowc2 = mysqli_fetch_array($ssc2,MYSQLI_ASSOC);
			$countc2 = mysqli_num_rows($ssc2);
			if($countc2 == 1) { 
				$temp = $rowc2['jml_produk_gudang'];				
				if($temp >= $jum){
					$kapasitas=$kapasitas+0;
				}else{
					$kapasitas=$kapasitas+1;
				}
			}
		
		//OVER KAPASITAS
		if ($kapasitas != 0){
			$istok=$istok+1;
		}
	}
		
	//CEK OVER KAPASITAS
	if ($istok != 0){
		$valid=2;
	}
	
	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		//PENGURANGAN STOK PRODUK GUDANG UTAMA
		$sqlc11="SELECT * FROM tb_detail_mankonsi 
		INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_mankonsi.produk_detmk 
		INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk WHERE tb_detail_mankonsi.nota_detmk='$ntj'";
		$ssc11=mysqli_query($kon,$sqlc11);
		while($rowc11=mysqli_fetch_array($ssc11)){
			$prod1=$rowc11['produk_detmk'];
			$jum1=$rowc11['qty_detmk'];
			
				$qw1 = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang-'$jum1', supplier_gudang='$id', staff_gudang='$id', 
					tgl_update_gudang=NOW() WHERE kode_produk_gudang='$prod1' AND kode_office_gudang='$off' AND event_gudang='OFFICE'";
				$res_qw1 = mysqli_query($kon,$qw1);
				if(!$res_qw1) {    
					$cek=$cek+1;
				}
				
		}
		
		//PEMBUATAN NOTA NTJ KONSI
		$qw2 = "INSERT INTO tb_jual_konsi(id_jk, tgl_order_jk, total_jk, cara_bayar_jk, status_jk, tgl_approv_jk, counter_jk, gudang_jk, keterangan_jk, jenis_jk, cs_jk,kantor_jk, retur_jk) 
		VALUES ('$kode', '$t_order', '$t_total', '$t_cara', 'SUCCESS', '$t_approv', '$t_counter', '$t_gudang', '$t_ket', '$t_jenis', '$t_cs', '$t_kantor', '0')";
		$res_qw2 = mysqli_query($kon,$qw2);
		if(!$res_qw2) {    
			$cek=$cek+1;
		}

		$sql2="SELECT * FROM tb_detail_mankonsi WHERE nota_detmk='$ntj'";
		$ss2=mysqli_query($kon,$sql2);
		while($row2=mysqli_fetch_array($ss2)){
			$i_produk=$row2['produk_detmk'];
			$i_harga=$row2['harga_detmk'];
			$i_qty=$row2['qty_detmk'];
			$i_diskon=$row2['diskon_detmk'];
			$i_totjum=$row2['totjum_detmk'];

			$qw3 = "INSERT INTO tb_detail_jual_konsi(nota_detjk, produk_detjk, harga_detjk, qty_detjk, diskon_detjk, totjum_detjk) 
			VALUES ('$kode', '$i_produk', '$i_harga', '$i_qty', '$i_diskon', '$i_totjum')";
			$res_qw3 = mysqli_query($kon,$qw3);	
			if(!$res_qw3) {    
				$cek=$cek+1;
			}
		}

		$qw4 = "UPDATE tb_man_konsi SET manual_mk='$kode', tgl_order_mk='$t_order', tgl_approv_mk='$t_approv' WHERE id_mk='$ntj'";
		$res_qw4 = mysqli_query($kon,$qw4);		
		if(!$res_qw4) {    
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Ditambahkan";		
			$status['nott']= $kode;
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
		$status['error']="Stok Gudang Tidak Mencukupi";
	}	

	echo json_encode($status);
?>
