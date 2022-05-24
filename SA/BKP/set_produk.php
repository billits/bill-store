<?php
  $id=$_POST['id'];
  $sumber = "http://localhost/BillServer/detail_data_produk.php?id=".$id;
  $konten = file_get_contents($sumber);
  $json = json_decode($konten, true);
                    
  for($a=0; $a < count($json); $a++) {
?>

                  <form method="post" id="form-edit">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Produk*</label>
                      <input class="form-control" type="text" name="kode_produk" readonly id="kode_produk" value="<?php echo $json[$a]['id_produk']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Produk*</label>
                      <input class="form-control" type="text" name="nama_produk" readonly id="nama_produk" value="<?php echo $json[$a]['nama_produk']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kategori">Kategori Produk*</label>
                      <input class="form-control" type="text" name="kategori2" readonly id="kategori2" value="<?php echo $json[$a]['nama_kategori']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="region">Region Produk*</label>
                      <select class="form-control" name="region" id="region">
                        <option value="">Pilih Region Produk</option>
    <?php
      $sumber1 = "http://localhost/BillServer/data_region.php";
      $konten1 = file_get_contents($sumber1);
      $json1 = json_decode($konten1, true);
                      
      for($a1=0; $a1 < count($json1); $a1++)
        {
    ?>
                      <option value="<?php echo $json1[$a1]['id_region']; ?>"><?php echo $json1[$a1]['nama_region']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="harga">Harga Produk*</label>
                      <input class="form-control" type="text" name="harga" id="harga" placeholder="25000" id="harga" required/>  
                    </div>
                  </form>

<?php
  }
?>