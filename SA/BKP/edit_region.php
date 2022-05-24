<?php
  $id=$_POST['id'];
  $sumber = "http://localhost/BillServer/detail_data_region.php?id=".$id;
  $konten = file_get_contents($sumber);
  $json = json_decode($konten, true);
                    
  for($a=0; $a < count($json); $a++) {
?>

                  <form method="post" id="form-edit-region">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Modal Name">Kode Region</label>
                      <input type="text" name="kode_region"  id="kode_region" class="form-control" readonly value="<?php echo $json[$a]['id_region']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Nama Region</label>
                      <input type="text" name="nama_region" id="nama_region" class="form-control" value="<?php echo $json[$a]['nama_region']; ?>" required/>
                    </div>
                  </form>

<?php
  }
?>