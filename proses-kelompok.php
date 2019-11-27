<?php

function himpunanKeanggotaan($himpunan) {
    switch ($himpunan) {
        case 1:
            return "x";
        case 2:
            return "y";
        case 3:
            return "z";
    }
}

function namaHimpunanKeanggotaan($himpunan, $format = false) {
    switch ($himpunan) {
        case 1:
            $value = "Umur";
        break;
        case 2:
            $value = "Masa Kerja";
        break;
        case 3:
            $value = "Gaji";
        break;
    }

    return $format ? str_replace(" ", "_", strtolower($value)) : $value;
}

function derajatKeanggotaan($himpunan, $state, $nilai, $bawah, $tengah, $atas) {
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

require './koneksi.php';


$id = isset($_POST['id']) ? $_POST['id'] : "";

$content = "";

if (strlen(trim($id)) > 0) { 

    $sql = "SELECT * FROM karyawan";
    $query = mysqli_query($koneksi, $sql);
    $results_karyawan = mysqli_fetch_all($query, MYSQLI_ASSOC);

    $sqlKeanggotaan = "SELECT * FROM keanggotaan WHERE kelompok_id='$id'";
    $queryKeanggotaan = mysqli_query($koneksi, $sqlKeanggotaan);
    $results_keanggotaan = mysqli_fetch_all($queryKeanggotaan, MYSQLI_ASSOC);

    $rowLength = count($results_keanggotaan);
    $himpunan = himpunanKeanggotaan($id);

    $row = "";

    $nilai = namaHimpunanKeanggotaan($id, true);


    foreach ($results_karyawan as $karyawan) {
        $keanggotaan = "";

        $nilaiKaryawan = $karyawan[$nilai];

        foreach ($results_keanggotaan as $anggota) {
            $bawah = $anggota['bawah'];
            $tengah = $anggota['tengah'];
            $atas = $anggota['atas'];
            
            $keanggotaan .= "<td>" . derajatKeanggotaan($id, strtolower($anggota['nama']), $nilaiKaryawan, $bawah, $tengah, $atas) . "</td>";
        }                    

        $row .= "<tr>" .
                    "<td>" . $karyawan["nip"] . "</td>" .
                    "<td>" . $karyawan["nama"] . "</td>" .
                    "<td>" . number_format($nilaiKaryawan) . "</td>" .
                    $keanggotaan .
                "</tr>";
    }

    $headAnggota = "";

    foreach ($results_keanggotaan as $anggota) {
        $headAnggota .= "<th>" . $anggota["nama"] . "</th>";
    }

    $content  = "<table class='table'>" .
                    "<thead>" .
                        "<tr>" .
                            "<th rowspan='2'>NIP</th>" .
                            "<th rowspan='2'>Nama</th>" .
                            "<th rowspan='2'>" . namaHimpunanKeanggotaan($id) . "</th>" .
                            "<th class='text-center' colspan='$rowLength'>Derajat Keanggotaan ( &micro; $himpunan )</th>" .
                        "</tr>" .
                        "<tr>" .
                            $headAnggota .
                        "</tr>" .
                    "</thead>" .
                    "<tbody>" .
                        $row .
                    "</tbody>" .
                "</table>";
}

echo json_encode([
    'view' => $content
]);