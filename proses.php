<?php

require './koneksi.php';

$nama = isset($_POST['nama']) ? $_POST['nama'] : "";
$umur = isset($_POST['umur']) ? $_POST['umur'] : "";
$masa_kerja = isset($_POST['masa_kerja']) ? $_POST['masa_kerja'] : "";
$gaji = isset($_POST['gaji']) ? $_POST['gaji'] : "";

$delimeter_nama = isset($_POST['delimeter_nama']) ? $_POST['delimeter_nama'] : "";
$delimeter_umur = isset($_POST['delimeter_umur']) ? $_POST['delimeter_umur'] : "";
$delimeter_masa_kerja = isset($_POST['delimeter_masa_kerja']) ? $_POST['delimeter_masa_kerja'] : "";
$delimeter_gaji = isset($_POST['delimeter_gaji']) ? $_POST['delimeter_gaji'] : "";

$where = [];

if (strlen(trim($nama)) > 0) {
    if ($delimeter_nama == 'LIKE') {
        $where[] = "nama LIKE '%$nama%'";
    } else {
        $where[] = "nama $delimeter_nama '$nama'";
    }
}

if (strlen(trim($umur)) > 0) {
    if ($delimeter_umur == 'LIKE') {
        $where[] = "umur LIKE '%$umur%'";
    } else {
        $where[] = "umur $delimeter_umur '$umur'";
    }
}

if (strlen(trim($masa_kerja)) > 0) {
    if ($delimeter_masa_kerja == 'LIKE') {
        $where[] = "masa_kerja LIKE '%$masa_kerja%'";
    } else {
        $where[] = "masa_kerja $delimeter_masa_kerja '$masa_kerja'";
    }
}

if (strlen(trim($gaji)) > 0) {
    if ($delimeter_gaji == 'LIKE') {
        $where[] = "gaji LIKE '%$gaji%'";
    } else {
        $where[] = "gaji $delimeter_gaji '$gaji'";
    }
}

$sqlWhere = "";

if (count($where) > 0) {
    $sqlWhere = "WHERE " . implode(" AND ", $where);
}

$sql = "SELECT * FROM karyawan " . $sqlWhere;
$query = mysqli_query($koneksi, $sql);
$results = mysqli_fetch_all($query, MYSQLI_ASSOC);

$content = "";

foreach ($results as $result) {
    $content .= "<tr>" . 
                    "<td>" . $result["nip"] . "</td>" .
                    "<td>" . $result["nama"] . "</td>" .
                    "<td>" . $result["umur"] . "</td>" .
                    "<td>" . $result["masa_kerja"] . "</td>" .
                    "<td>" . number_format($result["gaji"]) . "</td>" .
                "</tr>";
}

echo json_encode([
    'view' => $content
]);