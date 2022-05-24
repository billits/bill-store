<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	$count =0;
	// 1 - data kosong
	// 2 - sudah diproses
	
	$nota = $_POST['nota'];
	$staff = $_POST['staff'];
	$off = $_POST['off'];
	
  if (empty($nota)||empty($staff)||empty($off)){
		$valid=1;
	}

	$query = "SELECT * FROM tb_retur_transaksi WHERE id_retur='$nota'";
	$result = mysqli_query($kon, $query);
	$baris = mysqli_fetch_array($result,MYSQLI_ASSOC);

	$acara = $baris['event_retur'];
	$kantor = $baris['kantor_retur'];
	$tgl_order = $baris['waktu_retur'];
	$status_order = $baris['status_retur'];
	$ntj = $baris['notajual_retur'];

	if($status_order=='SUCCESS'){
		$valid=2;
	}

	$query1 = "SELECT * FROM tb_jual WHERE id_jual='$ntj'";
	$result1 = mysqli_query($kon, $query1);
	$baris1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

	$tgl_order1 = $baris1['tgl_order_jual'];
	$status_order1 = $baris1['status_jual'];
	$tgl_order2 = $baris1['tgl_approv_jual'];

	if($status_order1=='RETUR'){
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		$sql="SELECT * FROM tb_detail_jual 
		INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual.produk_detjual 
		INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
		WHERE tb_detail_jual.nota_detjual='$ntj'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){
			$pro=$data['produk_detjual'];
			$jum=$data['qty_detjual'];
			
			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
					tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='$acara'";
			$resltt = mysqli_query($kon,$sli);
	
			if(!$resltt) {    
				$cek=$cek+1;
			}			
		}	

		$sl1 = "UPDATE tb_retur_transaksi SET waktu_retur='$tgl_order', status_retur='SUCCESS' WHERE id_retur='$nota'";
		$reslt1 = mysqli_query($kon,$sl1);
		if(!$reslt1) {    
			$cek=$cek+1;
		}

		$sl2 = "UPDATE tb_jual SET tgl_order_jual='$tgl_order1', tgl_approv_jual='$tgl_order2', status_jual='RETUR' WHERE id_jual='$ntj'";
		$reslt2 = mysqli_query($kon,$sl2);
		if(!$reslt2) {    
			$cek=$cek+1;
		}

		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Di Retur";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Di Retur";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Sudah di Retur"; 
	}

	echo json_encode($status);
?>
