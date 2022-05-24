<?php
  include "../db_proses/koneksi.php";
  $id=$_POST['id'];
  $query = "SELECT * FROM tb_events WHERE id_events='$id'";
	$result = mysqli_query($kon, $query);
	
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-edit-region">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Modal Name">Kode Events</label>
                      <input type="text" name="kode_events"  id="kode_events" class="form-control" readonly value="<?php echo $baris['id_events']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Nama Events</label>
                      <input type="text" name="nama_events" id="nama_events" class="form-control" value="<?php echo $baris['nama_events']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Time Update Events</label>
                      <input type="text" name="time_events" id="time_events" class="form-control" readonly value="<?php echo date('d-m-Y H:i:s', strtotime($baris['time_events'])); 
                      ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Keterangan Events</label>
                      <input type="text" name="ket_events" id="ket_events" class="form-control" value="<?php echo $baris['keterangan_events']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="level">Tingkatan Events</label>
                      <input type="text" name="lvl_events" id="lvl_events" class="form-control" readonly value="<?php echo $baris['level_events']; ?>" required/>
                    </div>            
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Ganti Tingkat Events*</label>
                      <select class="form-control" name="lvl_events1" id="lvl_events1">
                        <option value="">Pilih Tingkatan</option>
                        <option value="BESAR">BESAR</option>
                        <option value="SEDANG">SEDANG</option>
                      </select>
                    </div>
                  </form>

<?php
  }
?>