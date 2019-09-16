<?php
include "../koneksi.php";
include "../helper.php";
if($_GET['action'] == "table_data"){
    $sql= "SELECT id_peserta,nama,email,alamat,no_hp FROM tbl_peserta order by nama asc";
    $stmt = $dbh->query($sql);
    $jumlah = $stmt->rowCount();
    $data = array();
    $no = 1;
    while($r = $stmt->fetchObject()){
       $id = $r->id_peserta;
       $row = array();
       $row[] = '<div class="text-center">'.$no.'</div>';
       $row[] = $r->nama;
       $row[] = '<div class="text-right">'.$r->no_hp.'</div>';
       $row[] = $r->email;
       $row[] = $r->alamat;
       $row[] = '<div class="text-center">
                   <button style="color:#fff;" class="btn btn-primary" onclick="form_edit('.$id.')">Ubah</button>
                   <button style="color:#fff;" class="btn btn-danger" onclick="delete_data('.$id.')">Hapus</button>
                 </div>';
       $data[] = $row;
       $no++;
    }
        
    $output = array("draw"=>1,"recordsTotal"=>$jumlah,"recordsFiltered"=>$jumlah,"data" => $data);
    echo json_encode($output);
}elseif($_GET['action'] == "form_data"){
  $sql= "SELECT id_peserta,nama,email,alamat,no_hp FROM tbl_peserta where id_peserta='$_GET[id]'";
  $stmt = $dbh->query($sql);
  $data  = $stmt->fetchObject();  
  echo json_encode($data);
}elseif($_GET['action'] == "update"){
   $id = $_POST['id'];
   $nama = $_POST['nama'];
   $email = $_POST['email'];
   $alamat = $_POST['alamat'];
   $no_hp = $_POST['no_hp'];

   $sql = "UPDATE tbl_peserta SET nama = :nama,email = :email,alamat = :alamat,no_hp = :no_hp WHERE id_peserta = :id_peserta";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id_peserta', $id, PDO::PARAM_STR);
        $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
        $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':no_hp', $no_hp, PDO::PARAM_STR);
        $result = $stmt->execute(); 

}elseif($_GET['action'] == "insert"){

   $nama = $_POST['nama'];
   $email = $_POST['email'];
   $alamat = $_POST['alamat'];
   $no_hp = $_POST['no_hp'];

   $sql = "INSERT INTO tbl_peserta SET nama = :nama,email = :email,alamat = :alamat,no_hp = :no_hp";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
        $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':no_hp', $no_hp, PDO::PARAM_STR);
        $result = $stmt->execute(); 

}elseif($_GET['action'] == "delete"){
   $sql = "DELETE FROM tbl_peserta WHERE id_peserta='$_GET[id]'";
   $stmt = $dbh->query($sql);
   $result = $stmt->execute();
}


?>