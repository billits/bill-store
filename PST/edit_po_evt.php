<?php
  include "../db_proses/koneksi.php";
  $id=$_POST['id'];
  $pdk=$_POST['pdk'];

  $query = "SELECT * FROM tb_detail_beli_event 
	INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli_event.produk_detbelev 
	INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
	INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev 
	WHERE tb_detail_beli_event.nota_detbelev='$id' AND tb_detail_beli_event.produk_detbelev='$pdk'";
	$result = mysqli_query($kon, $query);
	
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-edit">
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
                      <label for="jumlah">Qty Produk*</label>
                      <input class="form-control" type="hidden" name="price" id="price" onkeyup="myFunction()" value="<?php echo $baris['harga_harian']; ?>"/>
                      <input class="form-control" type="text" name="qty" id="qty" placeholder="Qty" onkeyup="myFunction()" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="total">Total Harga*</label>
                      <input class="form-control" type="text" name="total" id="total" readonly required/>  
                    </div>
                      <input class="form-control" type="hidden" name="nota" id="nota" value="<?php echo $id; ?>"readonly required/>
                      <input class="form-control" type="hidden" name="jum_old" id="jum_old" value="<?php echo $baris['total_jumlah_detbelev']; ?>"/>
                  </form>

<?php
  }
?>