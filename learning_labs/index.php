<?php
session_start();
include 'koneksi.php';

// mengambil semua tugas dari databse
function getTasks($koneksi) {
    $tugas = [];
    $result = $koneksi->query("SELECT * FROM tugas");
    while ($row = $result->fetch_assoc()) {
        $tugas[] = $row;
    }
    return $tugas;
}

// tambah
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $time = $_POST['time'];
    $query = "INSERT INTO tugas (task, time) VALUES ('$task', '$time')";
    $koneksi->query($query);
}

// update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];
    $time = $_POST['time'];
    $query = "UPDATE tugas SET task='$task', time='$time' WHERE id=$id";
    $koneksi->query($query);
}

// hapus
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM tugas WHERE id=$id";
    $koneksi->query($query);
}

$tugas = getTasks($koneksi); // Ambil semua tugas dari database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List ⋆˚✿˖°ִֶָ་࿐</title>
</head>
<body>
    <h1>To Do List ⋆˚✿˖°ִֶָ་࿐</h1>
    <form method="post" action="">
        <input type="text" name="task" required>
        <input type="time" name="time" required>
        <button type="submit" name="add">Tambah</button>
    </form>

    <h2>⤷ Daftar Tugas °❀⋆.*</h2>
    <ul>
    <?php
    // menampilkan semua tugas dari databse
    if (count($tugas) > 0) {
        foreach ($tugas as $task) {
            echo "<li>{$task['task']} >> {$task['time']} 
                    <a href='?edit={$task['id']}'>Edit</a> 
                    <a href='?delete={$task['id']}'>Hapus</a>
                  </li>";
        }
    } else {
        echo "Tidak ada tugas yay ^o^ .";
    }
    ?>
    </ul>

    <?php
    // form edit
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        // Mengambil tugas yang ingin diedit
        $query = "SELECT * FROM tugas WHERE id=$id";
        $result = $koneksi->query($query);
        $task = $result->fetch_assoc();

        echo "<h2>Edit Tugas ୨ৎ</h2>
              <form method='post' action=''>
                  <input type='hidden' name='id' value='{$task['id']}'>
                  <input type='text' name='task' value='{$task['task']}' required>
                  <input type='time' name='time' value='{$task['time']}' required>
                  <button type='submit' name='update'>Update</button>
              </form>";
    }
    ?>
</body>
</html>
