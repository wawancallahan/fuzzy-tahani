<?php
    require './koneksi.php';

    $sql = "SELECT * FROM kelompok";
    $query = mysqli_query($koneksi, $sql);
    $result_kelompok = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fuzzy Tahani</title>

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">

        <div class="row mb-5">
            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-4" for="">Nama</label>
                        <div class="col-8">
                            <div class="btn-group">
                                <select name="delimeter_nama" id="delimeter_nama" class="form-control">
                                    <option value="=" selected>=</option>
                                    <option value=">=">>=</option>
                                    <option value="<="><=</option>
                                    <option value=">">></option>
                                    <option value="<"><</option>
                                    <option value="LIKE">LIKE</option>
                                </select>
                                <input class="form-control" type="text" name="nama" id="nama">
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-4" for="">Umur</label>
                        <div class="col-8">
                            <div class="btn-group">
                                <select name="delimeter_umur" id="delimeter_umur" class="form-control">
                                    <option value="=" selected>=</option>
                                    <option value=">=">>=</option>
                                    <option value="<="><=</option>
                                    <option value=">">></option>
                                    <option value="<"><</option>
                                    <option value="LIKE">LIKE</option>
                                </select>
                                <input class="form-control" type="text" name="umur" id="umur">
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-4" for="">Masa Kerja</label>
                        <div class="col-8">
                            <div class="btn-group">
                                <select name="delimeter_masa_kerja" id="delimeter_masa_kerja" class="form-control">
                                    <option value="=" selected>=</option>
                                    <option value=">=">>=</option>
                                    <option value="<="><=</option>
                                    <option value=">">></option>
                                    <option value="<"><</option>
                                    <option value="LIKE">LIKE</option>
                                </select>
                                <input class="form-control" type="text" name="masa_kerja" id="masa_kerja">
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-4" for="">Gaji</label>
                        <div class="col-8">
                            <div class="btn-group">
                                <select name="delimeter_gaji" id="delimeter_gaji" class="form-control">
                                    <option value="=" selected>=</option>
                                    <option value=">=">>=</option>
                                    <option value="<="><=</option>
                                    <option value=">">></option>
                                    <option value="<"><</option>
                                    <option value="LIKE">LIKE</option>
                                </select>
                                <input class="form-control" type="text" name="gaji" id="gaji">
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
            <div class="col-12">
                <button type="button" class="btn btn-primary btn-block" id="pencarian">Cari</button>
                <button type="button" class="btn btn-danger btn-block" id="reset">Reset</button>
            </div>   
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Umur (thn)</th>
                        <th>Masa Kerja (thn)</th>
                        <th>Gaji/ Bln (Rp)</th>
                    </tr>
                </thead>
                <tbody id="tabel-karyawan">

                </tbody>
            </table>
        </div>

        <div class="mb-5">
            <div class="row form-group">
                <label class="control-label col-4" for="">Kelompok</label>
                <div class="col-8">
                    <select name="kelompok" id="kelompok" class="form-control">
                        <option value="" selected>Pilih Kelompok</option>
                        <?php foreach ($result_kelompok as $kelompok) { ?>
                            <option value="<?php echo $kelompok["id"] ?>"><?php echo $kelompok["nama"] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-block" id="pencarian-kelompok">Cari</button>
        </div>

        <div class="table-responsive mb-5" id="table-keanggotaan">

        </div>

        <div class="mb-5">
            <div class="row form-group">
                <label class="control-label col-4" for="">Fungsi Keanggotaan</label>
                <div class="col-8">
                    <select name="fungsi_keanggotaan" id="fungsi_keanggotaan" class="form-control">
                        <option value="" selected>Pilih Fungsi Keanggotaan</option>
                        <option value="1">Karyawan Masih Muda Dan Memiliki Gaji Tinggi</option>
                        <option value="2">Karyawan Masih Muda Atau Memiliki Gaji Tinggi</option>
                        <option value="3">Karyawan Masih Muda Dan Memiliki Masa Kerja Lama</option>
                        <option value="4">Karyawan Masih Parobaya Dan (Memiliki Gaji Sedang Atau Memiliki Masa Kerja Lama)</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-block" id="pencarian-fungsi-keanggotaan">Cari</button>
        </div>

        <div class="table-responsive mb-5" id="table-fungsi-keanggotaan">

        </div>
    </div>
    
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>

    <script>
        function fetchData (request = {}) {
            $('#tabel-karyawan').empty();
            $.ajax({
                url: '/proses.php',
                type: 'POST',
                data: request,
                dataType: 'json'
            }).then(function (response) {
                $('#tabel-karyawan').html(response.view);
            }).fail(function (error) {
                console.log(error);
            });
        }

        function fetchDataKelompok (request = {}) {
            $('#table-keanggotaan').empty();
            $.ajax({
                url: '/proses-kelompok.php',
                type: 'POST',
                data: request,
                dataType: 'json'
            }).then(function (response) {
                $('#table-keanggotaan').html(response.view);
            }).fail(function (error) {
                console.log(error);
            });
        }

        $(function () {
            fetchData();

            $('#pencarian-kelompok').click(function (e) {
                e.preventDefault();

                fetchDataKelompok({
                    id: $('#kelompok').val()
                })
            });

            $('#pencarian').click(function (e) {
                e.preventDefault();
                
                fetchData({
                    nama: $('#nama').val(),
                    umur: $('#umur').val(),
                    masa_kerja: $('#masa_kerja').val(),
                    gaji: $('#gaji').val(),
                    delimeter_nama: $('#delimeter_nama').val(),
                    delimeter_umur: $('#delimeter_umur').val(),
                    delimeter_masa_kerja: $('#delimeter_masa_kerja').val(),
                    delimeter_gaji: $('#delimeter_gaji').val()
                });
            });

            $('#reset').click(function (e) {
                e.preventDefault();

                fetchData();

                $('#nama').val("");
                $('#umur').val("");
                $('#masa_kerja').val("");
                $('#gaji').val("");
                $('#delimeter_nama').val("=").trigger('change');
                $('#delimeter_umur').val("=").trigger('change');
                $('#delimeter_masa_kerja').val("=").trigger('change');
                $('#delimeter_gaji').val("=").trigger('change');
            });
        });
    </script>
</body>
</html>