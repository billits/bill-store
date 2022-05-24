<?php
  $id=$_POST['id'];
  $sumber = "http://localhost/BillServer/detail_data_kategori.php?id=".$id;
  $konten = file_get_contents($sumber);
  $json = json_decode($konten, true);
                    
  for($a=0; $a < count($json); $a++) {
?>

                  <form method="post" id="form-edit">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Modal Name">Kode Kategori</label>
                      <input type="text" name="kode_kategori"  id="kode_kategori" class="form-control" readonly value="<?php echo $json[$a]['id_kategori']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Nama Kategori</label>
                      <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?php echo $json[$a]['nama_kategori']; ?>" required/>
                    </div>
                  </form>

<?php
  }
?>