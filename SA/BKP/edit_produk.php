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
                      <input class="form-control" type="text" name="nama_produk" id="nama_produk" value="<?php echo $json[$a]['nama_produk']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kategori">Kategori Produk*</label>
                      <input class="form-control" type="text" name="kategori2" readonly id="kategori2" value="<?php echo $json[$a]['nama_kategori']; ?>" required/>  
                      <input type="hidden" name="kategori" id="kategori" value="<?php echo $json[$a]['kategori_produk']; ?>">
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Kategori Produk Baru*</label>
                      <select class="form-control" name="kategori1" id="kategori1">
                        <option value="">Pilih Kategori Produk</option>
    <?php
      $sumber1 = "http://localhost/BillServer/data_kategori.php";
      $konten1 = file_get_contents($sumber1);
      $json1 = json_decode($konten1, true);
                      
      for($a1=0; $a1 < count($json1); $a1++)
        {
    ?>
                      <option value="<?php echo $json1[$a1]['id_kategori']; ?>"><?php echo $json1[$a1]['nama_kategori']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                  </form>

<?php
  }
?>