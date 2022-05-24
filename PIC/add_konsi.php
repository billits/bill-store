<?php
  include ('akses.php');
  include ('../_partials/partial_none.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
    <script>
      function myFunction() {        
        
        var Dibayar=parseInt($('#Dibayar').val());
        var Subtotal=parseInt($('#bayar').val());
        var Voucher=parseInt($('#Voucher').val());

        var hrg_final=Subtotal-Voucher;
        var kembalian=Dibayar-hrg_final; 

        var reverse = hrg_final.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = 'Rp. '+ribuan.join('.').split('').reverse().join('');
        document.getElementById("total").value = ribuan;   

        var reverse1 = kembalian.toString().split('').reverse().join(''),
        ewuan = reverse1.match(/\d{1,3}/g);
        if (hrg_final > Dibayar){
          ewuan = '- Rp. '+ewuan.join('.').split('').reverse().join('');
        }else{
          ewuan = 'Rp. '+ewuan.join('.').split('').reverse().join('');
        }
        document.getElementById("Kembali").value = ewuan;   

      }
    </script>
  </head>


  <body id="page-top">
    <?php echo $topnav; ?>

    <div id="wrapper">
      <?php echo $topside; ?>

      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
          Konsi Leader <?php echo $_COOKIE['office_bill']; ?>
          </ol>

          <!-- DataTables Example -->
          <div id="Transaksi">          
          </div>

          <!-- Modal Popup untuk Tambah Data Produk--> 
          <div id="ModalApp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Approve Data Order Produk</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-approv">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Pelanggan*</label>
                      <input class="form-control" type="text" name="nama" id="nama" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Keterangan*</label>
                      <input class="form-control" type="text" name="ket" id="ket" required/>  
                      <input type="hidden" name="nota" id="nota" value="">
                      <input type="hidden" name="office" id="office" value="">
                      <input type="hidden" name="bayar" id="bayar" value="">
                      <input type="hidden" name="pegawai" id="pegawai" value="">
                    </div>     
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="rp_bayar">Total*</label>
                      <input class="form-control" type="text" name="rp_bayar" id="rp_bayar" readonly required/>  
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit">Approve</button>
                      <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <?php
          echo $footer;
        ?>
        
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
		<?php
      echo $logout;
    ?>

    <?php
      echo $csjs2;
    ?>

    <script type="text/javascript">
      function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
        });
        return vars;
      }
      $(document).ready(function(){
        var idnota = getUrlVars()["nota"];
        
        var datastok = "data_konsi.php?nota="+idnota;
        $('#Transaksi').load(datastok); 

        $(document).on('click','#addpro',function(e){
          e.preventDefault();
          window.location= 'add_konsi_pro.php?nota='+idnota;
        });

        $(document).on("click", ".open-ModalApp", function () {          
          var office = '<?php echo $_COOKIE["office_bill"];?>';        
          var pegawai = '<?php echo $_COOKIE["idstaff_bill"];?>';
          var id_nota = $(this).data('idnota');
          var total_bayar = $(this).data('tot');
          var rp_tot = total_bayar;

          var reverse9 = rp_tot.toString().split('').reverse().join(''),
          ribuan = reverse9.match(/\d{1,3}/g);
          ribuan = 'Rp. '+ribuan.join('.').split('').reverse().join('');
           
          $(".modal-body #nota").val( id_nota );
          $(".modal-body #bayar").val( total_bayar );
          $(".modal-body #office").val( office );
          $(".modal-body #pegawai").val( pegawai );
          $(".modal-body #rp_bayar").val( ribuan );
        });

        $('#form-approv').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-approv").serialize();
          $.ajax({
            url:"../db_proses/add_konsi.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 

                //Program Nota Masuk Disini
                var nota_tmp = obj.nott;
                window.open(
                  '../Print Nota NTJ2.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'konsi_off.php';
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        $(document).on('click','#hapus',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-nota');
          var ppdk = $(this).attr('data-pdk');
          var pjum = $(this).attr('data-jum');
          bootbox.dialog({
            message: "Hapus Produk ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_konsi.php', { 'kode_nota':pnot, 'kode_produk':ppdk, 'jum_produk':pjum })
                  .done(function(html){      
                    $('#Transaksi').load(datastok);   
                  })
                  .fail(function(){
                    bootbox.alert('Something Went Wrog ....');
                  })
                }
              }, 
              success: {
                label: "Tidak",
                className: "btn-danger",
                callback: function() {
                  $('.bootbox').modal('hide');
                }
              }
            }
         });
        });

        $(document).on('click','#batal',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-nota');
          bootbox.dialog({
            message: "Batalkan Konsi ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/delete_konsinyasi.php', { 'kode_nota':pnot })
                  .done(function(html){             
                    window.location= 'konsi_off.php';
                  })
                  .fail(function(){
                    bootbox.alert('Something Went Wrog ....');
                  })
                }
              }, 
              success: {
                label: "Tidak",
                className: "btn-danger",
                callback: function() {
                  $('.bootbox').modal('hide');
                }
              }
            }
          });
        });
        
      })
    </script>

  </body>
  
</html>

