<?php
  include "../db_proses/koneksi.php";
  $id=$_POST['id'];
  $query = "SELECT * FROM tb_detail_events WHERE id_det_event='$id'";
	$result = mysqli_query($kon, $query);
	
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-edit-region">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Modal Name">Events</label>
                      <input type="text" name="jenis_evt"  id="jenis_evt" class="form-control" readonly value="<?php echo $baris['event_det_event']; ?>" required readonly/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Nama Events</label>
                      <input type="text" name="nama_evt" id="nama_evt" class="form-control" value="<?php echo $baris['nama_det_event']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Time Update Events</label>
                      <input type="text" name="time_evt" id="time_evt" class="form-control" readonly value="<?php echo date('d-m-Y H:i:s', strtotime($baris['time_det_event'])); ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Keterangan Events</label>
                      <input type="text" name="ket_evt" id="ket_evt" class="form-control" value="<?php echo $baris['keterangan_det_event']; ?>" required/>
                      <input type="hidden" name="id_evt" id="id_evt" value="<?php echo $id; ?>"/>
                      <input type="hidden" name="statevt1" id="statevt1" value="<?php echo $baris['status_det_event']; ?>"/>
                    </div>
                  </form>

<?php
  }
?>