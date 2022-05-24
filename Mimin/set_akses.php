<?php
	include "../db_proses/koneksi.php";
  $id=$_POST['id'];
  $query = "SELECT * FROM tb_staff INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff WHERE tb_staff.kode_staff='$id'";
	$result = mysqli_query($kon, $query);
	
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-edit">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Pegawai*</label>
                      <input class="form-control" type="text" name="id_pegawai" id="id_pegawai" readonly value="<?php echo $baris['kode_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Pegawai*</label>
                      <input class="form-control" type="text" name="nama_pegawai" readonly id="nama_pegawai" value="<?php echo $baris['nama_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="office">Office Pegawai*</label>
                      <input class="form-control" type="text" name="office_pegawai2" readonly id="office_pegawai2" value="<?php echo $baris['nama_office']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="akses">Akses*</label>
                      <select class="form-control" name="akses" id="akses">
                        <option value="">Pilih Akses</option>
                        <option value="PUSAT">PUSAT</option>
                        <option value="HEAD">HEAD</option>  
                        <option value="COUNTER">COUNTER</option>
                        <option value="GUDANG">GUDANG</option>
                      </select>
                    </div>
                    
                  </form>

<?php
  }
?>