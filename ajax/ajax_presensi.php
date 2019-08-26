<?php
include "../koneksi.php";
if($_GET['action'] == "data"){
	$html = '';
	$presensi = $_GET['presensi'];
	$no = 1;
	$sqlPresensi  = "SELECT * FROM tbl_detail_presensi tdp join tbl_presensi tp on tdp.id_presensi = tp.id_presensi join tbl_peserta tps on tdp.id_peserta = tps.id_peserta where tdp.id_presensi= '$presensi'";
	$stmtPresensi = $dbh->prepare($sqlPresensi);
	$stmtPresensi->execute();
	$no = 1;
	while($rowPresensi = $stmtPresensi->fetchObject()){    
		$html .= "<tr>
		    <td class='text-center'>$no</td>
		    <td class='text-center'>".ucwords(strtolower($rowPresensi->nama))."</td>
		    <td class='text-center'>";
		    $p = ($rowPresensi->ho == '0') ? "Belum" : "Sudah"; 
		$html .= $p."</td>";
        $html .= '<td class="text-center"><button class="btn btn-sm btn-danger" onclick="hapus(\''.$rowPresensi->id_presensi.'\',\''.$rowPresensi->id_peserta.'\')">X</button>';
        $html .= "</td>
        </tr>";  
		$no++;
	}
	 echo json_encode(array("data_presensi"=>$html));
}elseif ($_GET['action'] == "insert") {
	$id_presensi = $_POST['id_presensi'];
	$peserta = $_POST['peserta'];
    $sudah_ho = $_POST['sudah_ho'];

    $cekSudahPresensi = "SELECT * FROM tbl_detail_presensi WHERE id_presensi='$id_presensi' and id_peserta = '$peserta'";   
    $stmt = $dbh->query($cekSudahPresensi);
    $jmlSudahPresensi = $stmt->rowCount();
    if($jmlSudahPresensi > 0){
        $sql = "UPDATE tbl_detail_presensi SET ho = :sudah_ho WHERE id_presensi = :id_presensi and id_peserta = :id_peserta";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id_presensi', $id_presensi, PDO::PARAM_STR);
        $stmt->bindParam(':id_peserta', $peserta, PDO::PARAM_STR);
        $stmt->bindParam(':sudah_ho', $sudah_ho, PDO::PARAM_STR);
        $result = $stmt->execute();

        $data =array("method"=>"Update","hasil"=>$result);
        echo json_encode($data);
    }else{
        $sql = "INSERT INTO tbl_detail_presensi(
                id_presensi,id_peserta,ho) VALUES (
                :id_presensi,:id_peserta,:sudah_ho)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id_presensi', $id_presensi, PDO::PARAM_STR);
        $stmt->bindParam(':id_peserta', $peserta, PDO::PARAM_STR);
        $stmt->bindParam(':sudah_ho', $sudah_ho, PDO::PARAM_STR);
        $result = $stmt->execute();
        $data =array("method"=>"Insert","hasil"=>$result);
        echo json_encode($data);
    }

}elseif ($_GET['action'] == "hapus") {
    $id_presensi = $_GET['id_presensi'];
    $id_peserta = $_GET['id_peserta'];
    $sql = "DELETE FROM tbl_detail_presensi WHERE id_presensi = :id_presensi and id_peserta = :id_peserta";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id_presensi', $id_presensi, PDO::PARAM_STR);
    $stmt->bindParam(':id_peserta', $id_peserta, PDO::PARAM_STR);
    $result = $stmt->execute();

}elseif ($_GET['action'] == "cekPasswordBatal") {
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $salted = "87123yhejhagdsagsd7aw".$password."babsjhasbsbhhq13bjbj";
    $hashed = hash("sha512", $salted);
    $cekuser = "SELECT * FROM tbl_user WHERE password='$hashed'";
    $stmt = $dbh->query($cekuser);
    $jmluser = $stmt->rowCount();
    $row = $stmt->fetchObject();
    if($jmluser > 0){
        $id_presensi = $_POST['id_presensi'];
        $sql = "DELETE FROM tbl_detail_presensi WHERE id_presensi = :id_presensi";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id_presensi', $id_presensi, PDO::PARAM_STR);
        $result = $stmt->execute();
        $data =array("method"=>"cekPasswordBatal","hasil"=>$result);
        echo json_encode($data);
    }else{
        $data =array("method"=>"cekPasswordBatal","hasil"=>false);
        echo json_encode($data);
    }


}elseif ($_GET['action'] == "cekPasswordSelesai") {
     $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $salted = "87123yhejhagdsagsd7aw".$password."babsjhasbsbhhq13bjbj";
    $hashed = hash("sha512", $salted);
    $cekuser = "SELECT * FROM tbl_user WHERE password='$hashed'";
    $stmt = $dbh->query($cekuser);
    $jmluser = $stmt->rowCount();
    $row = $stmt->fetchObject();
    if($jmluser > 0){
       $data =array("method"=>"cekPasswordSelesai","hasil"=>true);
        echo json_encode($data);
    }else{
        $data =array("method"=>"cekPasswordSelesai","hasil"=>false);
        echo json_encode($data);
    }

}
?>