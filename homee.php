<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "mydb";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$tanggal         = "";
$id              = "";
$nik             = "";
$nama            = "";
$jenis_kelamin   = "";
$no_hp           = "";
$alamat          = "";
$no_rumah        = "";
$sttus           = "";
$sukses          = "";
$error           = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from checklist where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id              = $_GET['id'];
    $sql1            = "select * from checklist where id = '$id'";
    $q1              = mysqli_query($koneksi, $sql1);
    $r1              = mysqli_fetch_array($q1);
    $tanggal         = $r1['tanggal'];
    $id              = $r1['id'];
    $nik             = $r1['nik'];
    $nama            = $r1['nama'];
    $jenis_kelamin   = $r1['jenis_kelamin'];
    $no_hp           = $r1['no_hp'];
    $alamat          = $r1['alamat'];
    $no_rumah        = $r1['no_rumah'];
    $status          = $r1['status'];

    if ($tanggal == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $tanggal            = $_POST['tanggal'];
    $id                 = $_POST['id'];
    $nik                = $_POST['nik'];
    $nama               = $_POST['nama'];
    $jenis_kelamin      = $_POST['jenis_kelamin'];
    $no_hp              = $_POST['no_hp'];
    $alamat             = $_POST['alamat'];
    $no_rumah           = $_POST['no_rumah'];
    $status             = $_POST['status'];

    if ($tanggal && $id && $nik && $nama && $jenis_kelamin && $no_hp && $alamat && $no_rumah && $status) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update checklist set tanggal = '$tanggal',id='$id',nik= '$nik',nama='$nama',jenis_kelamin='$jenis_kelamin',no_hp='$no_hp',alamat='$alamat',no_rumah='$no_rumah',status='$status' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into checklist(tanggal,id,nik,nama,jenis_kelamin,no_hp,alamat,no_rumah,status) values ('$tanggal','$id','$nik','$nama','$jenis_kelamin','$no_hp','$alamat','$no_rumah','$status')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checklist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit checklist
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=home.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=home.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm-2 col-form-label">TANGGAL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id" class="col-sm-2 col-form-label">id</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id" name="id" value="<?php echo $id ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nik" class="col-sm-2 col-form-label">nik</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="nik" id="nik">
                                <option value="">- Pilih Kondisi nik -</option>
                                <option value="bersih" <?php if ($nik == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($nik == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($nik == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">nama</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="nama" id="nama">
                                <option value="">- Pilih Kondisi nama -</option>
                                <option value="bersih" <?php if ($nama == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($nama == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($nama == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">jenis_kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                <option value="">- Pilih Kondisi Lantai -</option>
                                <option value="bersih" <?php if ($jenis_kelamin == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($jenis_kelamin == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($jenis_kelamin == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_hp" class="col-sm-2 col-form-label">no_hp</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="no_hp" id="no_hp">
                                <option value="">- Pilih Kondisi Dinding -</option>
                                <option value="bersih" <?php if ($no_hp == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($no_hp == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($no_hp == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">alamat</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="alamat" id="alamat">
                                <option value="">- Pilih Kondisi Kaca -</option>
                                <option value="bersih" <?php if ($alamat == "bersih") echo "selected" ?>>Bersih</option>
                                <option value="kotor" <?php if ($alamat == "kotor") echo "selected" ?>>Kotor</option>
                                <option value="rusak" <?php if ($alamat == "rusak") echo "selected" ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_rumah" class="col-sm-2 col-form-label">no_rumah</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="no_rumah" id="no_rumah">
                                <option value="">- Pilih Kondisi no_rumah -</option>
                                <option value="ya" <?php if ($o_rumah == "ya") echo "selected" ?>>Ya</option>
                                <option value="tidak" <?php if ($no_rumah == "tidak") echo "selected" ?>>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status" id="status">
                                <option value="">- Pilih Kondisi Status -</option>
                                <option value="aktif" <?php if ($status == "aktif") echo "selected" ?>>Aktif</option>
                                <option value="nonaktif" <?php if ($status == "nonaktif") echo "selected" ?>>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Checklist
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">id</th>
                            <th scope="col">nik</th>
                            <th scope="col">nama</th>
                            <th scope="col">jenis_kelamin</th>
                            <th scope="col">no_hp</th>
                            <th scope="col">alamat</th>
                            <th scope="col">no_rumah</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from checklist order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id             = $r2['id'];
                            $tanggal        = $r2['tanggal'];
                            $id             = $r2['id'];
                            $nik            = $r2['nik'];
                            $nama           = $r2['nama'];
                            $jenis_kelamin  = $r2['jenis_kelamin'];
                            $no_hp          = $r2['no_hp'];
                            $alamat         = $r2['alamat'];
                            $no_rumah       = $r2['no_rumah'];
                            $status         = $r2['status'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $tanggal ?></td>
                                <td scope="row"><?php echo $id ?></td>
                                <td scope="row"><?php echo $nik ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $jenis_kelamin ?></td>
                                <td scope="row"><?php echo $no_hp ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $no_rumah ?></td>
                                <td scope="row"><?php echo $status ?></td>
                                <td scope="row">
                                    <a href="home.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="home.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>in