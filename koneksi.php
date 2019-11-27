<?php

$koneksi = mysqli_connect("127.0.0.1", "root", "", "tahani");

if ( ! $koneksi) {
    echo "Koneksi Bermasalah " . mysqli_connect_error();

    die();
}