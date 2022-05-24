<?php
  include ('akses.php');
  include ('../_partials/partial_pic.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
  </head>


  <body id="page-top">
    <?php echo $topnav; ?>

    <div id="wrapper">
      <?php echo $topside; ?>

      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="home.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active"> Manual Konsi Leader <?php echo $_COOKIE['office_bill']; ?></li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataTrans">
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
      $(document).ready(function(){
        var datatrans = "data_man_konsi.php";
        $('#DataTrans').load(datatrans); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_detail_man_konsi.php?id="+datatmp;
          $('#DataTrans').load(datalap); 
        });

        $(document).on('click','#addtrans',function(e){
          e.preventDefault();
          $.ajax({
            url:"../db_proses/add_newman_konsi.php",
            type:"POST",
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                window.location= 'add_man_konsi.php?nota='+obj.nota;
              }else{
                alert(obj.error); 
              }
            }
          })
        });
        
        $(document).on('click','#kembali',function(e){
          e.preventDefault();
        $('#DataTrans').load(datatrans); 
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();          
          var nota_tmp = $(this).attr('data-id');
          window.open(
            '../Print Nota MNJ2.php?nota='+nota_tmp,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

        $(document).on('click','#delet',function(e){
          e.preventDefault();
          var pnot = $(this).attr('data-id');
          bootbox.dialog({
            message: "Yakin Cancel ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/cancel_konsiman.php', { 'nota':pnot })
                  .done(function(html){             
                    // window.location= 'ru_evt.php';
                    bootbox.alert('Data Berhasil di Cancel');
                    $('#DataTrans').load(datatrans); 
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

