<?php

require './koneksi.php';

function derajatKeanggotaan($himpunan, $state, $nilai, $bawah, $tengah, $atas)
{
    $value = 0;

    switch ($himpunan) {
        case 1:
            switch ($state) {
                case "muda":
                    if ($nilai < $tengah) {
                        $value = 1;
                    } else if ($nilai >= $tengah && $nilai <= $atas) {
                        $value = ($atas - $nilai) / ($atas - $tengah);
                    } else if ($nilai > $atas) {
                        $value = 0;
                    }
                    break;
                case "parobaya":
                    if ($nilai < $bawah || $nilai > $atas) {
                        $value = 0;
                    } else if ($nilai >= $bawah && $nilai <= $tengah) {
                        $value = ($nilai - $bawah) / ($tengah - $bawah);
                    } else if ($nilai > $tengah && $nilai <= $atas) {
                        $value = ($atas - $nilai) / ($atas - $tengah);
                    }
                    break;
                case "tua":
                    if ($nilai < $bawah) {
                        $value = 0;
                    } else if ($nilai >= $bawah && $nilai <= $tengah) {
                        $value = ($nilai - $bawah) / ($tengah - $bawah);
                    } else if ($nilai > $tengah) {
                        $value = 1;
                    }
                    break;
            }
            break;
        case 2:
            switch ($state) {
                case "baru":
                    if ($nilai < $tengah) {
                        $value = 1;
                    } else if ($nilai >= $tengah && $nilai <= $atas) {
                        $value = ($atas - $nilai) / ($atas - $tengah);
                    } else if ($nilai > $atas) {
                        $value = 0;
                    }
                    break;
                case "lama":
                    if ($nilai < $bawah) {
                        $value = 0;
                    } else if ($nilai >= $bawah && $nilai <= $tengah) {
                        $value = ($nilai - $bawah) / ($tengah - $bawah);
                    } else if ($nilai > $tengah) {
                        $value = 1;
                    }
                    break;
            }
            break;
        case 3:
            switch ($state) {
                case "rendah":
                    if ($nilai < $tengah) {
                        $value = 1;
                    } else if ($nilai >= $tengah && $nilai <= $atas) {
                        $value = ($atas - $nilai) / ($atas - $tengah);
                    } else if ($nilai > $atas) {
                        $value = 0;
                    }
                    break;
                case "sedang":
                    if ($nilai < $bawah || $nilai > $atas) {
                        $value = 0;
                    } else if ($nilai >= $bawah && $nilai <= $tengah) {
                        $value = ($nilai - $bawah) / ($tengah - $bawah);
                    } else if ($nilai > $tengah && $nilai <= $atas) {
                        $value = ($atas - $nilai) / ($atas - $tengah);
                    }
                    break;
                case "tinggi":
                    if ($nilai < $bawah) {
                        $value = 0;
                    } else if ($nilai >= $bawah && $nilai <= $tengah) {
                        $value = ($nilai - $bawah) / ($tengah - $bawah);
                    } else if ($nilai > $tengah) {
                        $value = 1;
                    }
                    break;
            }
            break;
    }

    return number_format($value, 2, ".", "");
}

function ambilKeanggotaan($koneksi, $id, $param = null)
{
    $sqlKeanggotaan = "SELECT * FROM keanggotaan WHERE kelompok_id='$id'";

    if ($param !== null) {
        $sqlKeanggotaan .= " AND nama = '$param'";
    }

    $queryKeanggotaan = mysqli_query($koneksi, $sqlKeanggotaan);
    return mysqli_fetch_all($queryKeanggotaan, MYSQLI_ASSOC);
}

function himpunanKeanggotaan($koneksi, $id)
{
    $content = "";

    switch ($id) {
        case 1:
            // Umur Muda dan Gaji Tinggi
            $umur = ambilKeanggotaan($koneksi, 1, "muda");
            $gaji = ambilKeanggotaan($koneksi, 3, "tinggi");

            $sql = "SELECT * FROM karyawan";
            $query = mysqli_query($koneksi, $sql);
            $results_karyawan = mysqli_fetch_all($query, MYSQLI_ASSOC);

            $umur = isset($umur[0]) ? $umur[0] : null;
            $gaji = isset($gaji[0]) ? $gaji[0] : null;

            foreach ($results_karyawan as $karyawan) {
                $muda = 0;
                $tinggi = 0;

                if ($umur !== null) {
                    $muda = derajatKeanggotaan(1, "muda", $karyawan["umur"], $umur["bawah"], $umur["tengah"], $umur["atas"]);
                }

                if ($gaji !== null) {
                    $tinggi = derajatKeanggotaan(3, "tinggi", $karyawan["gaji"], $gaji["bawah"], $gaji["tengah"], $gaji["atas"]);
                }

                $row = "<td>" . $muda . "</td>" .
                    "<td>" . $tinggi . "</td>" .
                    "<td>" . min($muda, $tinggi) . "</td>";

                $content .= "<tr>" .
                    "<td>" . $karyawan["nip"] . "</td>" .
                    "<td>" . $karyawan["nama"] . "</td>" .
                    "<td>" . $karyawan["umur"] . "</td>" .
                    "<td>" . number_format($karyawan["gaji"]) . "</td>" .
                    $row .
                    "</tr>";
            }

            $content  = "<table class='table'>" .
                "<thead>" .
                "<tr>" .
                "<th rowspan='2'>NIP</th>" .
                "<th rowspan='2'>Nama</th>" .
                "<th rowspan='2'>Umur</th>" .
                "<th rowspan='2'>Gaji</th>" .
                "<th class='text-center' colspan='3'>Derajat Keanggotaan</th>" .
                "</tr>" .
                "<tr>" .
                "<th>Umur Muda</th>" .
                "<th>Gaji Tinggi</th>" .
                "<th>Hasil</th>" .
                "</tr>" .
                "</thead>" .
                "<tbody>" .
                $content .
                "</tbody>" .
                "</table>";

            break;
        case 2:
            // Umur Muda atau Gaji Tinggi
            $umur = ambilKeanggotaan($koneksi, 1, "muda");
            $gaji = ambilKeanggotaan($koneksi, 3, "tinggi");

            $sql = "SELECT * FROM karyawan";
            $query = mysqli_query($koneksi, $sql);
            $results_karyawan = mysqli_fetch_all($query, MYSQLI_ASSOC);

            $umur = isset($umur[0]) ? $umur[0] : null;
            $gaji = isset($gaji[0]) ? $gaji[0] : null;

            foreach ($results_karyawan as $karyawan) {
                $muda = 0;
                $tinggi = 0;

                if ($umur !== null) {
                    $muda = derajatKeanggotaan(1, "muda", $karyawan["umur"], $umur["bawah"], $umur["tengah"], $umur["atas"]);
                }

                if ($gaji !== null) {
                    $tinggi = derajatKeanggotaan(3, "tinggi", $karyawan["gaji"], $gaji["bawah"], $gaji["tengah"], $gaji["atas"]);
                }

                $row = "<td>" . $muda . "</td>" .
                    "<td>" . $tinggi . "</td>" .
                    "<td>" . max($muda, $tinggi) . "</td>";

                $content .= "<tr>" .
                    "<td>" . $karyawan["nip"] . "</td>" .
                    "<td>" . $karyawan["nama"] . "</td>" .
                    "<td>" . $karyawan["umur"] . "</td>" .
                    "<td>" . number_format($karyawan["gaji"]) . "</td>" .
                    $row .
                    "</tr>";
            }

            $content  = "<table class='table'>" .
                "<thead>" .
                "<tr>" .
                "<th rowspan='2'>NIP</th>" .
                "<th rowspan='2'>Nama</th>" .
                "<th rowspan='2'>Umur</th>" .
                "<th rowspan='2'>Gaji</th>" .
                "<th class='text-center' colspan='3'>Derajat Keanggotaan</th>" .
                "</tr>" .
                "<tr>" .
                "<th>Umur Muda</th>" .
                "<th>Gaji Tinggi</th>" .
                "<th>Hasil</th>" .
                "</tr>" .
                "</thead>" .
                "<tbody>" .
                $content .
                "</tbody>" .
                "</table>";

            break;
        case 3:
            // Umur Muda dan Masa Kerja Lama
            $umur = ambilKeanggotaan($koneksi, 1, "muda");
            $masa_kerja = ambilKeanggotaan($koneksi, 2, "lama");

            $sql = "SELECT * FROM karyawan";
            $query = mysqli_query($koneksi, $sql);
            $results_karyawan = mysqli_fetch_all($query, MYSQLI_ASSOC);

            $umur = isset($umur[0]) ? $umur[0] : null;
            $masa_kerja = isset($masa_kerja[0]) ? $masa_kerja[0] : null;

            foreach ($results_karyawan as $karyawan) {
                $muda = 0;
                $tinggi = 0;

                if ($umur !== null) {
                    $muda = derajatKeanggotaan(1, "muda", $karyawan["umur"], $umur["bawah"], $umur["tengah"], $umur["atas"]);
                }

                if ($masa_kerja !== null) {
                    $tinggi = derajatKeanggotaan(3, "tinggi", $karyawan["masa_kerja"], $masa_kerja["bawah"], $masa_kerja["tengah"], $masa_kerja["atas"]);
                }

                $row = "<td>" . $muda . "</td>" .
                    "<td>" . $tinggi . "</td>" .
                    "<td>" . min($muda, $tinggi) . "</td>";

                $content .= "<tr>" .
                    "<td>" . $karyawan["nip"] . "</td>" .
                    "<td>" . $karyawan["nama"] . "</td>" .
                    "<td>" . $karyawan["umur"] . "</td>" .
                    "<td>" . $karyawan["masa_kerja"] . "</td>" .
                    $row .
                    "</tr>";
            }

            $content  = "<table class='table'>" .
                "<thead>" .
                "<tr>" .
                "<th rowspan='2'>NIP</th>" .
                "<th rowspan='2'>Nama</th>" .
                "<th rowspan='2'>Umur</th>" .
                "<th rowspan='2'>Masa Kerja</th>" .
                "<th class='text-center' colspan='3'>Derajat Keanggotaan</th>" .
                "</tr>" .
                "<tr>" .
                "<th>Umur Muda</th>" .
                "<th>Masa Kerja Lama</th>" .
                "<th>Hasil</th>" .
                "</tr>" .
                "</thead>" .
                "<tbody>" .
                $content .
                "</tbody>" .
                "</table>";

            break;
        case 4:
            // Umur Parobaya dan (Gaji Sedang atau Masa Kerja Lama)
            $umur = ambilKeanggotaan($koneksi, 1, "parobaya");
            $gaji = ambilKeanggotaan($koneksi, 3, "sedang");
            $masa_kerja = ambilKeanggotaan($koneksi, 2, "lama");

            $sql = "SELECT * FROM karyawan";
            $query = mysqli_query($koneksi, $sql);
            $results_karyawan = mysqli_fetch_all($query, MYSQLI_ASSOC);

            $umur = isset($umur[0]) ? $umur[0] : null;
            $masa_kerja = isset($masa_kerja[0]) ? $masa_kerja[0] : null;
            $gaji = isset($gaji[0]) ? $gaji[0] : null;

            foreach ($results_karyawan as $karyawan) {
                $muda = 0;
                $tinggi = 0;
                $sedang = 0;

                if ($umur !== null) {
                    $muda = derajatKeanggotaan(1, "parobaya", $karyawan["umur"], $umur["bawah"], $umur["tengah"], $umur["atas"]);
                }

                if ($gaji !== null) {
                    $sedang = derajatKeanggotaan(3, "sedang", $karyawan["gaji"], $gaji["bawah"], $gaji["tengah"], $gaji["atas"]);
                }

                if ($masa_kerja !== null) {
                    $tinggi = derajatKeanggotaan(2, "lama", $karyawan["masa_kerja"], $masa_kerja["bawah"], $masa_kerja["tengah"], $masa_kerja["atas"]);
                }

                $row = "<td>" . $muda . "</td>" .
                    "<td>" . $sedang . "</td>" .
                    "<td>" . $tinggi . "</td>" .
                    "<td>" . max($sedang, $tinggi) . "</td>" .
                    "<td>" . min($muda, max($sedang, $tinggi)) . "</td>";

                $content .= "<tr>" .
                    "<td>" . $karyawan["nip"] . "</td>" .
                    "<td>" . $karyawan["nama"] . "</td>" .
                    "<td>" . $karyawan["umur"] . "</td>" .
                    "<td>" . $karyawan["gaji"] . "</td>" .
                    "<td>" . $karyawan["masa_kerja"] . "</td>" .
                    $row .
                    "</tr>";
            }

            $content  = "<table class='table'>" .
                "<thead>" .
                "<tr>" .
                "<th rowspan='2'>NIP</th>" .
                "<th rowspan='2'>Nama</th>" .
                "<th rowspan='2'>Umur</th>" .
                "<th rowspan='2'>Gaji</th>" .
                "<th rowspan='2'>Masa Kerja</th>" .
                "<th class='text-center' colspan='5'>Derajat Keanggotaan</th>" .
                "</tr>" .
                "<tr>" .
                "<th>Umur Parobaya</th>" .
                "<th>Gaji Sedang</th>" .
                "<th>Masa Kerja Lama</th>" .
                "<th>(Gaji Sedang Atau Masa Kerja Lama)</th>" .
                "<th>Hasil</th>" .
                "</tr>" .
                "</thead>" .
                "<tbody>" .
                $content .
                "</tbody>" .
                "</table>";
            break;
    }

    return $content;
}

$id = isset($_POST['id']) ? $_POST['id'] : "";

$keanggotaan = "";

if (strlen(trim($id)) > 0) {
    $sql = "SELECT * FROM karyawan";
    $query = mysqli_query($koneksi, $sql);
    $results_karyawan = mysqli_fetch_all($query, MYSQLI_ASSOC);

    $keanggotaan = himpunanKeanggotaan($koneksi, $id);
}
echo json_encode([
    'view' => $keanggotaan
]);
