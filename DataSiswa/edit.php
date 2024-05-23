<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST["btn-update"])) 
    {
        $Index = $_GET["index"];
        $Nama = $_POST["nama"];
        $NIS = $_POST["nis"];
        $Rayon = $_POST["rayon"];
        $_SESSION['data_siswa'][$Index] = array(
            'nama' => $Nama,
            'nis' => $NIS,
            'rayon' => $Rayon
        );
        header("Location: index.php");
        exit;
    }
}
if (!isset($_GET["index"])) 
{
    header("Location: index.php");
    exit;
}

$Index = $_GET["index"];

if (!isset($_SESSION['data_siswa'][$Index])) 
{ 
    header("Location: index.php");
    exit;
}

$siswa = $_SESSION['data_siswa'][$Index];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="public/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            display: inline-block;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            margin-right: 10px;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Edit Data Siswa</h2>
        <form method="post">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" id="nis" name="nis" value="<?php echo htmlspecialchars($siswa['nis']); ?>" required>
            </div>
            <div class="form-group">
                <label for="rayon">Rayon:</label>
                <input type="text" id="rayon" name="rayon" value="<?php echo htmlspecialchars($siswa['rayon']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btn-update">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
