<?php 
error_reporting(E_ERROR | E_PARSE);
session_start();
ob_start();

//Mengecek status login
if(!isset($_SESSION['username']) or !isset($_SESSION['password'])){
  session_start();
  session_destroy();
   echo "<script>
      window.location = 'index.php';
      </script>";
}
 include 'koneksi.php'; 
 include 'helper.php';
 if(isset($_GET['episode'])){
  $episode = $_GET['episode'];
  $id = $_GET['id'];
  $sql  = "SELECT * FROM tbl_presensi tp join tbl_episode te on tp.id_episode = te.id_episode join tbl_sesi ts on te.id_sesi = ts.id_sesi where tp.id_episode = :episode";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':episode', $episode, PDO::PARAM_STR);
  $stmt->execute();
  $row =$stmt->fetchObject(); 
  $rowCount = $stmt->rowCount();
  if($rowCount < 1 ){
    echo "<script>
      alert('Kelas Tidak Ada');
      window.location = 'kelas.php';
      </script>";  
  }
}else{
   echo "<script>
      alert('Kelas Tidak Ada');
      window.location = 'kelas.php';
      </script>"; 
}
 ?>
<!doctype html>
<html lang="en">

<head>
  <title>Presensi</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/animate.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div class="container-fluid gradient-2">
    <!-- line -->
    <div class="row position-relative">
      <div class="col-5 position-absolute d-inline-block line animated fadeInRight">
        <img src="./assets/logoBG.png" class="d-flex mx-auto w-75 mt-5 animated fadeInDown">
        <img src="./assets/logo-bawah.png" style="position: absolute; bottom: 0" alt="">
      </div>
    </div>

    <div class="row h-100 align-items-center">

      <div class="col-5">
        <div class="row justify-content-center">
          <div class="col-10">
            <h1 style="margin-top: -80px;">PRESENSI KELAS</h1>
            <h1>EKSEKUTIF</h1>
            <h1>#YUK NGAJI</h1>

            <form  onsubmit="return presensi()">
              <input type="hidden" id="id_presensi" value="<?php echo $row->id_presensi ?>">
              <div class="input-group mb-3 animated fadeInRight mt-5">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="Peserta">Nama Peserta</label>
                </div>
                  <select class="custom-select" id="peserta" name="peserta" required>
                  <option value="">-- Pilih --</option>
                    <?php 
                        $sqlPeserta= "SELECT id_peserta,nama FROM tbl_peserta order by nama asc";
                        $stmtPeserta = $dbh->query($sqlPeserta);
                        while($rowPeserta = $stmtPeserta->fetchObject()){
                          echo "<option value='".$rowPeserta->id_peserta."'>".ucwords(strtolower($rowPeserta->nama))."</option>";    
                        }
                     ?>
                </select>
              </div>

              <div class="custom-control custom-switch h-50">
                <input type="checkbox" class="custom-control-input" id="sudah_ho">
                <label class="custom-control-label" for="sudah_ho">SUDAH HO?</label>
              </div>

              <button class="btn btn-light float-right" type="submit">CHECK IN ></button>
            </form>

          </div>
        </div>
      </div>

      <div class="col-7">
        <div class="row justify-content-center">
          <h1 class="text-center pt-3"><?php echo $row->nama_sesi.' | '.$row->nama_episode; ?></h1>
          <h2 class="mb-4 text-center"><?php echo tglindonesia($row->tanggal).' | '.$row->tempat; ?></h2>
          <div id="data" class="col-10 table-responsive-sm  table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-bordered bg-light">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Peserta</th>
                  <th class="text-center">Sudah HO</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                
                
                
              </tbody>
            </table>

          
          </div>
         
        </div>
         <div class="row justify-content-center mt-3">
          <div class="col-10">
             <button type="button" onclick="form_selesai()" class="btn btn-success float-right mr-3">SELESAI DAN SIMPAN</button> <button type="button"  onclick="form_batal()" class="btn btn-danger float-right" style="margin-right: 10px;">BATALKAN PRESENSI</button> 
              
          </div>
        </div>

      </div>


    </div>

  </div>

<!-- Modal Batalkan -->
<div class="modal fade" id="frm_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form onsubmit="return cekPassword()">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title" style="color: #000;">Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <input type="hidden" id="id_presensi_password" value="<?php echo $row->id_presensi ?>">
           <input class="form-control" type="password" id="password" required placeholder="Masukkan Password">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

    </div>
  </div>
</div>


  <script src="./js/jquery-3.3.1.min.js"></script>
  <script src="./js/bootstrap.bundle.min.js"></script>

  <script type="text/javascript">
    var url,method_type;
    $(document).ready(function(){
      getData(<?php echo $row->id_presensi ?>);

    });
    function getData(presensi){
      $.ajax({
        type: "GET", // Method pengiriman data bisa dengan GET atau POST
        url: "ajax/ajax_presensi.php?action=data&presensi="+presensi, // Isi dengan url/path file php yang dituju
        dataType: "json",
        beforeSend: function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response){ // Ketika proses pengiriman berhasil
          $("tbody").html(response.data_presensi).show();
          var elem = document.getElementById('data');
          elem.scrollTop = elem.scrollHeight;
        },
        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
          alert(thrownError); // Munculkan alert error
        }
      });
    }

    function presensi(){
          url = "ajax/ajax_presensi.php?action=insert";
          var data=new FormData();
          var id_presensi     = document.getElementById("id_presensi").value;
          var peserta     = document.getElementById("peserta").value;
          var sudah_ho    = "";

          if ($('#sudah_ho').is(':checked')){ 
            sudah_ho = "1";
          } 
          else { 
            sudah_ho = "0";
          }
          
          data.append('id_presensi',id_presensi);
          data.append('peserta',peserta);
          data.append('sudah_ho',sudah_ho);
           
           
          
          $.ajax({
            url : url,
            type : "POST",
            data : data,
            dataType : "json",
            processData: false,
            contentType: false,        
            success : function(data){
              getData(<?php echo $row->id_presensi ?>);
              
            },
            error : function(){
                alert("Tidak dapat menyimpan data!");
            }        
          });
          return false;
    }
     function hapus(id_presensi,id_peserta){
         if(confirm("Apakah yakin data akan dihapus?")){
      $.ajax({
         url : "ajax/ajax_presensi.php?action=hapus&id_presensi="+id_presensi+"&id_peserta="+id_peserta,
         type : "GET",
         success : function(data){
           getData(<?php echo $row->id_presensi ?>);
         },
         error : function(){
            alert("Gagal Hapus");
         }
      });
   }
     }

      function form_batal(){
         type = "1";
         $('#frm_password').modal('show');
         $('#modal-title').html('Batalkan Presensi?');
         $('#frm_password form')[0].reset();
      }

      function form_selesai(){
         type = "2";
         $('#frm_password').modal('show');
         $('#modal-title').html('Selesai dan Simpan Presensi?');
         $('#frm_password form')[0].reset();
      }

     function cekPassword(){
      if(type == 1){
        url = "ajax/ajax_presensi.php?action=cekPasswordBatal";
      }else{
        url = "ajax/ajax_presensi.php?action=cekPasswordSelesai";
      }
   
          var data=new FormData();
          var id_presensi     = document.getElementById("id_presensi_password").value;
          var password     = document.getElementById("password").value;
          

      
          data.append('password',password);
          data.append('id_presensi',id_presensi);
           
           
          
          $.ajax({
            url : url,
            type : "POST",
            data : data,
            dataType : "json",
            processData: false,
            contentType: false,        
            success : function(data){
              if(data.hasil == true && data.method == "cekPasswordBatal"){
                alert("Batalkan Presensi Berhasil");
                window.location = 'kelas.php';  
              }else if(data.hasil == true && data.method == "cekPasswordSelesai"){
                alert("Data Presensi Tersimpan");
                window.location = 'kelas.php';
              }else{
                alert("Password Salah");
              }
              
            },
            error : function(){
                alert("Tidak dapat menyimpan data!");
            }        
          });
          return false;
      }
 
  </script>

</body>

</html>