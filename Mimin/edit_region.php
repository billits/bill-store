<?php
  include "../db_proses/koneksi.php";
  $id=$_POST['id'];

	$query = "SELECT * FROM tb_region WHERE id_region='$id'";
  $result = mysqli_query($kon, $query);
  
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-edit-region">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Modal Name">Kode Region</label>
                      <input type="text" name="kode_region"  id="kode_region" class="form-control" readonly value="<?php echo $baris['id_region']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Nama Region</label>
                      <input type="text" name="nama_region" id="nama_region" class="form-control" value="<?php echo $baris['nama_region']; ?>" required/>
                    </div>
                  </form>

<?php
  }
?>