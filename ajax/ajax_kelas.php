<?php
include "../koneksi.php";
include "../helper.php";
if($_GET['action'] == "option_episode"){
	// Ambil data Sesi yang dikirim via ajax post
	$sesi_kelas = $_GET['sesi_kelas'];
	$html = '<option value="">-- Pilih --</option>';
                    
    $sql= "SELECT id_episode,nama_episode FROM tbl_episode where id_sesi = '$sesi_kelas'";
    $stmt = $dbh->query($sql);
    while($row = $stmt->fetchObject()){
      $html .= "<option value='".$row->id_episode."'>".$row->nama_episode."</option>";    
    }

    echo json_encode(array("data_episode"=>$html));
                    
}elseif ($_GET['action'] == "insert") {
	$episode_sesi = $_POST['episode_sesi'];
    $tempat = $_POST['tempat'];
    $tanggal = $_POST['tanggal'];
    $tanggalSplit = explode("-", $tanggal);
    $tanggalFinal = $tanggalSplit[2]."-".$tanggalSplit[1]."-".$tanggalSplit[0];
    $cekPresensi = "SELECT * FROM tbl_presensi WHERE id_episode='$episode_sesi'";   
    $stmt = $dbh->query($cekPresensi);
    $jmlPresensi = $stmt->rowCount();
    if($jmlPresensi > 0){
        $sql = "UPDATE tbl_presensi SET tempat = :tempat,tanggal = :tanggal WHERE id_episode = :id_episode";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id_episode', $episode_sesi, PDO::PARAM_STR);
        $stmt->bindParam(':tempat', $tempat, PDO::PARAM_STR);
        $stmt->bindParam(':tanggal', $tanggalFinal, PDO::PARAM_STR);
        $result = $stmt->execute();

        $data =array("method"=>"Update","hasil"=>$result);
        echo json_encode($data);
    }else{
        $sql = "INSERT INTO tbl_presensi(
                id_episode,tempat,tanggal) VALUES (
                :id_episode,:tempat,:tanggal)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id_episode', $episode_sesi, PDO::PARAM_STR);
        $stmt->bindParam(':tempat', $tempat, PDO::PARAM_STR);
        $stmt->bindParam(':tanggal', $tanggalFinal, PDO::PARAM_STR);
        $result = $stmt->execute();
        $data =array("method"=>"Insert","hasil"=>$result);
        echo json_encode($data);
    }

}elseif ($_GET['action'] == "cetak") {
    $id_presensi = $_GET['id_presensi'];
    $sqlPresensi= "SELECT * FROM tbl_presensi tp join tbl_episode te on tp.id_episode = te.id_episode join tbl_sesi ts on te.id_sesi = ts.id_sesi where tp.id_presensi = '$id_presensi'";
    $stmtPresensi = $dbh->query($sqlPresensi);
    $rowPresensi = $stmtPresensi->fetchObject();
    
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Presensi Sesi $rowPresensi->nama_sesi Episode $rowPresensi->nama_episode.xls");

    echo "<table>
     <tr>
        <td><b>Sesi : </b></td>
        <td>$rowPresensi->nama_sesi</td>
    </tr>
    <tr>
        <td><b>Episode : </b></td>
        <td>$rowPresensi->nama_episode</td>
    </tr>
    <tr>
        <td><b>Tempat : </b></td>
        <td>$rowPresensi->tempat</td>
    </tr>
    <tr>
        <td><b>Tanggal : </b></td>
        <td>".tglindonesia($rowPresensi->tanggal)."</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><b>Nama Peserta</b></td>
        <td><b>HO</b></td>
    </tr>";
    $sql= "SELECT * FROM tbl_detail_presensi tdp join tbl_presensi tp on tdp.id_presensi = tp.id_presensi join tbl_peserta tps on tdp.id_peserta = tps.id_peserta where tdp.id_presensi= '$id_presensi'";
    $sqlCountSudah= "SELECT * FROM tbl_detail_presensi tdp join tbl_presensi tp on tdp.id_presensi = tp.id_presensi join tbl_peserta tps on tdp.id_peserta = tps.id_peserta where tdp.id_presensi= '$id_presensi' and tdp.ho = '1'";
    $sqlCountBelum= "SELECT * FROM tbl_detail_presensi tdp join tbl_presensi tp on tdp.id_presensi = tp.id_presensi join tbl_peserta tps on tdp.id_peserta = tps.id_peserta where tdp.id_presensi= '$id_presensi' and tdp.ho = '0'";
    $stmt = $dbh->query($sql);
    $stmtCountSudah = $dbh->query($sqlCountSudah);
    $stmtCountBelum = $dbh->query($sqlCountBelum);
    $jmlSudah = $stmtCountSudah->rowCount();
    $jmlBelum = $stmtCountBelum->rowCount();
    while($row = $stmt->fetchObject()){
        echo "<tr>";
        $ho = '';
        if($row->ho == '0'){
            $ho = 'Belum';
        }else{
            $ho = 'sudah';
        }
        echo "<td>$row->nama</td>";
        echo "<td>$ho</td>";
        echo "</tr>";
    }
    echo "<tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><b>Sudah HO</b></td>
        <td>$jmlSudah</td>
    </tr>
    <tr>
        <td><b>Belum HO</b></td>
        <td>$jmlBelum</td>
    </tr>";
     echo "</table>";
}elseif ($_GET['action'] == "hapus") {
    $id_presensi = $_GET['id_presensi'];
    $sql = "DELETE FROM tbl_presensi WHERE id_presensi = :id_presensi";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id_presensi', $id_presensi, PDO::PARAM_STR);
    $result = $stmt->execute();
}