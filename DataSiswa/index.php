<?php 
session_start();

function is_data_exist($Nama, $NIS, $Rayon)
{
    foreach ($_SESSION['data_siswa'] as $Siswa)
    {
        if($Siswa['nama'] == $Nama && $Siswa['nis'] == $NIS && $Siswa['rayon'] == $Rayon)
        {
            return true;
        } 
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-submit"]))
{
    $Nama = $_POST["nama"];
    $NIS = $_POST["nis"];
    $Rayon = $_POST["rayon"];

    $NIS_exist = false;
    foreach ($_SESSION['data_siswa'] as $Siswa)
    {
        if($Siswa['nis'] == $NIS)
        {
            $NIS_exist = true;
            break;
        }
    }

    if(is_data_exist($Nama, $NIS, $Rayon)) 
    {
        $_SESSION['error_message'] = "Data sudah di terdaftar, tidak dapat menambahkan data";
    } elseif ($Siswa['nis'] === $NIS) 
    {
        $_SESSION['error_message'] = "NIS sudah terdaftar, silahkan masukan NIS yang benar";
    } else 
    {
        $_SESSION["data_siswa"][] = array('nama' => $Nama,'nis' => $NIS,'rayon' => $Rayon,
        );
        $_SESSION['success_message'] = "Data berhasil ditambahkan";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-delete"]))
{
    $index = $_POST["delete-index"];
    unset($_SESSION['data_siswa'][$index]);
    $_SESSION['data_siswa'] = array_values($_SESSION['data_siswa']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-edit"]))
{
    $index = $_POST["edit-index"];
    header("Location: edit.php?index=$index");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-print-all"])) 
{
    header("Location: print.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-delete-all"])) 
{
    unset($_SESSION['data_siswa']);
    $_SESSION['data_siswa'] = array();
    $_SESSION['success_message'] = "Semua data berhasil dihapus";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="public/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-container {
            margin-bottom: 20px;
        }
        .form-container h3 {
            margin-bottom: 20px;
        }
        .input-container {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .input-container input {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
            flex: 1;
        }
        .btn-collapse {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #fff;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert .btn-close {
            background: none;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background-color: #f8f9fa;
        }
        table .table-active {
            background-color: #e9ecef;
        }
        table .table-primary {
            background-color: #cce5ff;
        }
        .text-danger {
            color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container">
        <h3 class="text-center mt-4">Masukan Data Siswa</h3>
        <div class="d-flex justify-content-center">
            <form method="post" class="add-data d-flex justify-content-center flex-column mb-2">
                <div class="input-container d-flex gap-2">
                    <input type="text" placeholder="Masukan Nama" name="nama" required>
                    <input type="number" placeholder="Masukan NIS" name="nis" required>
                    <input type="text" placeholder="Masukan Rayon" name="rayon" required>
                </div> 
                <div style="margin-top:20px;">
                    <button type="submit" class="btn btn-primary btn-sm" name="btn-submit"><i class="fa-solid fa-plus"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
    <hr>
        <?php 
            if(isset($_SESSION["success_message"])) 
            {
                echo "<div class='alert alert-success' role='alert'>";
                echo $_SESSION['success_message'];
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>&times;</button>";
                echo '</div>';
                unset($_SESSION['success_message']);
            }

            if(isset($_SESSION["error_message"])) 
            {
                echo "<div class='alert alert-danger' role='alert'>";
                echo $_SESSION['error_message'];
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>&times;</button>";
                echo '</div>';
                unset($_SESSION['error_message']);
            }
        ?>
        <div>
            <table>
            <?php if(isset($_SESSION['data_siswa']) && !empty($_SESSION['data_siswa'])): ?>
                <div class="d-flex btn-collapse mt-2 mb-2 gap-2">
                    <form action="" method="post">
                        <button style="margin-top:10px; margin-bottom:10px;" type="submit" class="btn btn-warning btn-sm" name="btn-print-all"><i class="fa-solid fa-print"></i> Cetak</button>
                        <button style="margin-top:10px; margin-bottom:10px;" type="submit" class="btn btn-danger btn-sm" name="btn-delete-all"><i class='fa-solid fa-trash'></i> Hapus</button>
                    </form>
                </div>
            <?php endif; ?>
            <thead>
                <tr class="table-container table-primary" style="text-align: center;">
                    <th scope="col">No</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Rayon</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
                <tbody>
                <?php
                if (isset($_SESSION['data_siswa']) && !empty($_SESSION['data_siswa'])) 
                {
                    $Nomor = 1;
                    foreach ($_SESSION['data_siswa'] as $index => $Siswa) 
                    {
                        echo "<tr style='text-align: center;'>";
                        echo "<td>$Nomor</td>";
                        echo "<td>".$Siswa['nama']."</td>";
                        echo "<td>".$Siswa['nis']."</td>";
                        echo "<td>".$Siswa['rayon']."</td>";
                        echo "<td>
                            <form method='post' style='display:inline-block;'>
                                <input type='hidden' name='edit-index' value='$index'>
                                <button type='submit' class='btn btn-warning btn-sm' name='btn-edit'><i class='fa-solid fa-pencil'></i></button>
                            </form>
                            <br>
                            <br>

                            <form method='post' class='d-inline-block'>
                            <input type='hidden' name='delete-index' value='$index'>
                            <button type='submit' class='btn btn-danger btn-sm' name='btn-delete' style:margin-top><i class='fa-solid fa-trash'></i> </button>
                        </form>
                        </td>";
                        echo "</tr>";
                        $Nomor++;
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

