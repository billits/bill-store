<?php
  include "../db_proses/koneksi.php";

  $id=$_POST['id'];
  $query = "SELECT * FROM tb_kategori WHERE id_kategori='$id'";
  $result = mysqli_query($kon, $query);
  while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-edit">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Modal Name">Kode Kategori</label>
                      <input type="text" name="kode_kategori"  id="kode_kategori" class="form-control" readonly value="<?php echo $baris['id_kategori']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Nama Kategori</label>
                      <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?php echo $baris['nama_kategori']; ?>" required/>
                    </div>
                  </form>

<?php
  }
?>