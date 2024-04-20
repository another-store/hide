<?php
// Fungsi untuk memeriksa kredensial
function authenticate($username, $password) {
    // Baca data dari file JSON
    $json_data = file_get_contents('https://api.breaksek.com/admin.json');
    $users = json_decode($json_data, true);

    // Loop melalui daftar pengguna
    foreach ($users['users'] as $user) {
        // Periksa apakah username dan password cocok
        if ($user['username'] === $username && $user['password'] === $password) {
            return $user; // Mengembalikan data pengguna yang berhasil diautentikasi
        }
    }
    return false; // Autentikasi gagal
}

// Verifikasi apakah metode HTTP adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari input username dan password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Memanggil fungsi authenticate untuk memeriksa kredensial
    $authenticated_user = authenticate($username, $password);
    if ($authenticated_user) {
        // Jika autentikasi berhasil
        echo "Login successful! Welcome, {$authenticated_user['name']}";
        header("Location: dashboard/index.html");
    } else {
        // Jika autentikasi gagal
        echo "Invalid username or password. Please try again.";
    }
}
?>
