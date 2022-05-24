<?php
  include "../db_proses/koneksi.php";
  $id=$_POST['id'];
  $nota=$_POST['nota'];
  $office=$_POST['off'];

  $query = "SELECT * FROM tb_produk INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
	INNER JOIN tb_harga_produk ON tb_harga_produk.produk_harga=tb_produk.id_produk 
	INNER JOIN tb_region ON tb_region.id_region=tb_harga_produk.region_harga 
	INNER JOIN tb_office ON tb_office.region_office=tb_harga_produk.region_harga 
	WHERE tb_office.id_office='$office' AND tb_harga_produk.status_harga='ON' AND tb_produk.id_produk='$id' limit 1";
	$result = mysqli_query($kon, $query);
  $count = mysqli_num_rows($result); 
  if($count < 1) {
?>  
                  <h3><center>HARGA PRODUK BELUM DISETTING</center></h3>
<?php 
	} else{
	  while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-jum">
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
                      <input class="form-control" type="text" name="kategori" readonly id="kategori" value="<?php echo $baris['nama_kategori']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="jumlah">Qty Produk*</label>
                      <input class="form-control" type="hidden" name="price" id="price" onkeyup="myFunction()" value="<?php echo $baris['harga_harian']; ?>"/>
                      <input class="form-control" type="text" name="qty" id="qty" placeholder="Qty" onkeyup="myFunction()" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="total">Total Harga*</label>
                      <input class="form-control" type="text" name="total" id="total" readonly required/>  
                    </div>
                      <input class="form-control" type="hidden" name="nota" id="nota" value="<?php echo $nota; ?>"readonly required/>  
                      <input class="form-control" type="hidden" name="hh_pro" id="hh_pro" value="<?php echo $baris['id_harga']; ?>"readonly required/> 
                  </form>

<?php
    }
  }
?>