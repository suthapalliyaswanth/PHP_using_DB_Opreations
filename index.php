<?php
class CRUD {
    protected $dbhost = 'localhost';
    protected $dbuser = 'root';
    protected $dbpass = '';
    protected $dbname = 'db_crud_example'; 
    protected $mysqli;
    public $message;

    public function __construct() {
        $mysqli = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        if ($mysqli->connect_errno) die("Failed to connect DB: " . $mysqli->connect_error);
        $this->mysqli = $mysqli;
    }

    public function create_data($nim, $nama, $alamat, $jurusan) {
        $add = $this->mysqli->prepare("INSERT INTO `emp` (`nim`, `nama_lengkap`, `alamat`, `jurusan`) VALUES (?, ?, ?, ?)");
        $add->bind_param("isss", $nim, $nama, $alamat, $jurusan);
        $this->message = $add->execute();
        $add->close();
        return $this->message;
    }

    public function read_data($nim = '') {
        if (!empty($nim)) {
            $read = $this->mysqli->prepare("SELECT * FROM `emp` WHERE `nim` = ?");
            $read->bind_param("i", $nim);
            $this->message = $read->execute();
            $result = $read->get_result();
            return $result->fetch_assoc();
        } else {
            return $this->mysqli->query("SELECT * FROM `emp`")->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function update_data($nim, $nama, $alamat, $jurusan) {
        $add = $this->mysqli->prepare("UPDATE `emp` SET `nama_lengkap` = ?, `alamat` = ?, `jurusan` = ? WHERE `nim` = ?");
        $add->bind_param("sssi", $nama, $alamat, $jurusan, $nim);
        $this->message = $add->execute();
        $add->close();
        return $this->message;
    }

    public function delete_data($nim) {
        $del = $this->mysqli->prepare("DELETE FROM `emp` WHERE `nim` = ?");
        $del->bind_param("i", $nim);
        $this->message = $del->execute();
        $del->close();
        return $this->message;
    }
}

$crud = new CRUD;
$i = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP CRUD</title>
    <style>
        th {
            width: 200px;
            text-align: left;
        }
    </style>
</head>
<body>
<?php
if(isset($_GET['mode']) && !empty($_GET['mode'])) {
    if($_GET['mode'] == 'tambah') {
        if(isset($_POST['submit'])) {
            $crud->create_data(trim($_POST['nim']), trim($_POST['nama']), trim($_POST['alamat']), trim($_POST['jurusan']));
            echo $crud->message == 1 ? "<script>alert('Sukses tambah data')</script>" : "<script>alert('Gagal tambah data')</script>";
        }
?>
    <h3>Tambah Data | <a href="./">Home</a></h3>
    <form method="POST" action="./?mode=tambah">
        <table>
            <tr><th>NIM</th><td>: <input type="number" name="nim" required></td></tr>
            <tr><th>Nama Lengkap</th><td>: <input type="text" name="nama" required></td></tr>
            <tr><th>Alamat</th><td>: <input type="text" name="alamat" required></td></tr>
            <tr><th>Jurusan</th><td>: <input type="text" name="jurusan" required></td></tr>
            <tr><td><button type="submit" name="submit">Simpan</button></td></tr>
        </table>
    </form>
<?php
    } elseif ($_GET['mode'] == 'edit') {
        if (isset($_GET['nim']) && $data = $crud->read_data(trim($_GET['nim']))) {
            if (isset($_POST['submit'])) {
                $crud->update_data(trim($_POST['nim']), trim($_POST['nama']), trim($_POST['alamat']), trim($_POST['jurusan']));
                echo $crud->message == 1 ? "<script>alert('Sukses update data')</script>" : "<script>alert('Gagal update data')</script>";
                echo "<meta http-equiv='refresh' content='0;url=./?mode=edit&nim=".$_POST['nim']."'>";
            }
?>
    <h3>Edit Data | <a href="./">Home</a></h3>
    <form method="POST" action="./?mode=edit&nim=<?= $data['nim']; ?>">
        <table>
            <tr><th>NIM</th><td>: <input type="number" name="nim" value="<?= $data['nim']; ?>" readonly></td></tr>
            <tr><th>Nama Lengkap</th><td>: <input type="text" name="nama" value="<?= $data['nama_lengkap']; ?>" required></td></tr>
            <tr><th>Alamat</th><td>: <input type="text" name="alamat" value="<?= $data['alamat']; ?>" required></td></tr>
            <tr><th>Jurusan</th><td>: <input type="text" name="jurusan" value="<?= $data['jurusan']; ?>" required></td></tr>
            <tr><td><button type="submit" name="submit">Update</button></td></tr>
        </table>
    </form>
<?php
        } else {
            echo "Data not found. <a href='./'>Back to Home</a>";
        }
    } elseif ($_GET['mode'] == 'hapus') {
        if (isset($_GET['nim'])) {
            if ($crud->read_data(trim($_GET['nim']))) {
                $crud->delete_data(trim($_GET['nim']));
                echo $crud->message == 1 ? "<script>alert('Sukses hapus data')</script>" : "<script>alert('Gagal hapus data')</script>";
                echo "<meta http-equiv='refresh' content='0;url=./'>";
            } else {
                echo "Data not found. <a href='./'>Back to Home</a>";
            }
        }
    }
} else {
?>
    <h3>Home | <a href="./?mode=tambah">Tambah Data</a></h3>
    <table border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($crud->read_data() as $data) { ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $data['nim']; ?></td>
                    <td><?= $data['nama_lengkap']; ?></td>
                    <td><?= $data['alamat']; ?></td>
                    <td><?= $data['jurusan']; ?></td>
                    <td>
                        <a href="./?mode=edit&nim=<?= $data['nim']; ?>">EDIT</a> |
                        <a href="./?mode=hapus&nim=<?= $data['nim']; ?>" onclick="return confirm('Yakin mau hapus data ini?');">HAPUS</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
</body>
</html>
