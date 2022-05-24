<?php
  function rupiah($angka) {
	  $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
	  return $hasil_rupiah;
  }
  
  $id=$_POST['id'];
  $sumber = "http://localhost/BillServer/detail_harga_produk.php?id=".$id;
  $konten = file_get_contents($sumber);
  $json = json_decode($konten, true);
                    
  for($a=0; $a < count($json); $a++) {
?>

                  <form method="post" id="form-det">
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

                    <?php
                    $id1=$_POST['id'];
                    $sumber1 = "http://localhost/BillServer/detail_harga_harian.php?id=".$id;
                    $konten1 = file_get_contents($sumber1);
                    $json1 = json_decode($konten1, true);
                                      
                    for($a1=0; $a1 < count($json1); $a1++) {
                  ?>
                  
                  <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kategori"><?php echo $json1[$a1]['nama_region']; ?>*</label>
                      <input class="form-control" type="text" name="kategori2" readonly id="kategori2" value="<?php echo rupiah($json1[$a1]['harga_harian']); ?>" required/>  
                  </div>

                  <?php
                    }
                  ?>

                  </form>

<?php
  }
?>