<?php

$nama_mahasiswa = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $is_valid = true;
    $nama_mahasiswa = trim($_POST["nama"]);

    if (empty($nama_mahasiswa)) {
        $is_valid = false;
    }

    if (preg_match('/[0-9]/', $nama_mahasiswa)) {
        $is_valid = false;
    }

    if ($is_valid) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "maba_app";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            $message_type = "error";
        } else {
            $stmt = $conn->prepare("INSERT INTO calon_mahasiswa (nama) VALUES (?)");
            $stmt->bind_param("s", $nama_mahasiswa);

            if ($stmt->execute()) {
                $message_type = "success";
            } else {
                $message_type = "error";
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        $message_type = "error";
    }

    header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]) . "#" . $message_type);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Mahasiswa Baru USTI</title>

    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .modal {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0s 0.3s;
        }

        .modal:target {
            visibility: visible;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .modal:target>div {
            transform: scale(1);
            opacity: 1;
        }

        .modal>div {
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900">

    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-amber-50 to-gray-50 dark:from-gray-900 dark:via-blue-900/70 dark:to-black p-4">

        <div class="w-full max-w-md bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-2xl shadow-2xl shadow-blue-200/50 dark:shadow-black/50 p-8 space-y-6">
            <div class="mb-10 text-center">
                <div class="flex justify-center mb-3">
                    <div class="bg-gradient-to-br from-purple-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                        <img src="img/usti.png" alt="Logo USTI" class="w-20 h-20 m-2 object-contain">
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-blue-800 dark:text-white">Aplikasi Mahasiswa Baru</h1>
                <p class="text-lg text-yellow-800 dark:text-yellow-400 font-semibold">Universitas Sains dan Teknologi Indonesia</p>
            </div>

            <form class="flex flex-col items-center space-y-10" action="" method="POST">
                <div class="w-full">
                    <label for="nama" class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Calon Mahasiswa</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="nama" id="nama" class="block w-full pl-10 pr-3 py-3 bg-white/50 dark:bg-gray-700/50 border border-gray-900 dark:border-gray-300 rounded-lg dark:shadow-2xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition duration-150" placeholder="Contoh: Dwi Ramadhan Rivaldo">
                    </div>
                </div>

                <button type="submit" class="w-1/2 pt-2 flex items-center justify-center text-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-800 to-amber-600 hover:from-blue-900 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-0.5">
                    Simpan Data
                </button>
            </form>
        </div>
    </div>


    <div id="success" class="modal fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center space-y-6 transform transition-all">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-green-400">
                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Berhasil!</h3>
            <p class="text-gray-600 dark:text-gray-300">Data calon mahasiswa baru telah berhasil disimpan ke dalam sistem.</p>
            <a href="#" class="inline-block w-full px-4 py-3 bg-blue-700 text-white rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500 transition-transform transform hover:scale-105">Tutup</a>
        </div>
    </div>

    <div id="error" class="modal fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center space-y-6 transform transition-all">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-red-500 to-orange-500">
                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Terjadi Kesalahan!</h3>
            <p class="text-gray-600 dark:text-gray-300">Gagal menyimpan data. Silakan periksa kembali isian Anda dan coba lagi.</p>
            <a href="#" class="inline-block w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-red-500 transition-transform transform hover:scale-105">Coba Lagi</a>
        </div>
    </div>

</body>

</html>