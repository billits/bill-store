<?php
  include "../db_proses/koneksi.php";
  
  function rupiah($angka) {
	  $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
	  return $hasil_rupiah;
  }

  $id=$_POST['id'];
  $office=$_POST['off'];

  $query = "SELECT * FROM tb_produk INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
	INNER JOIN tb_harga_produk ON tb_harga_produk.produk_harga=tb_produk.id_produk 
	INNER JOIN tb_region ON tb_region.id_region=tb_harga_produk.region_harga 
	INNER JOIN tb_office ON tb_office.region_office=tb_harga_produk.region_harga 
	WHERE tb_office.id_office='$office' AND tb_harga_produk.status_harga='ON' AND tb_produk.id_produk='$id' limit 1";
  $result = mysqli_query($kon, $query);
  
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-det">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Produk*</label>
                      <input class="form-control" type="text" name="kode_produk" readonly id="kode_produk" value="<?php echo $baris['id_produk']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Produk*</label>
                      <input class="form-control" type="text" name="nama_produk" readonly id="nama_produk" value="<?php echo $baris['nama_produk']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kategori">Kategori Produk*</label>
                      <input class="form-control" type="text" name="kategori2" readonly id="kategori2" value="<?php echo $baris['nama_kategori']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kategori">Harga Region Produk*</label>
                      <input class="form-control" type="text" name="harga" readonly id="kategori2" value="<?php echo rupiah($baris['harga_harian']); ?>" required/>  
                    </div>
                  </form>

<?php
  }
?>