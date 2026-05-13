<?php
// =============================================
// KONFIGURASI DATABASE - Toko Kopi Kawan
// Sesuaikan kredensial di bawah jika berbeda
// =============================================
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'kopi_kawan_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            http_response_code(500);
            
            // Check if request expects JSON
            $isJson = (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
                      (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false);

            if ($isJson) {
                die(json_encode(['success' => false, 'error' => 'Koneksi database gagal. Silakan hubungi admin.']));
            } else {
                echo "<div style='padding:20px; border:2px solid #cf7354; background:#f4ead5; font-family:sans-serif; margin:20px; border-radius:8px;'>";
                echo "<h2 style='color:#cf7354; margin-top:0;'>⚠️ Database Error</h2>";
                echo "<p>Maaf, terjadi masalah saat menghubungkan ke database.</p>";
                echo "<p style='font-family:monospace; background:rgba(0,0,0,0.05); padding:10px;'>" . htmlspecialchars($e->getMessage()) . "</p>";
                echo "<p>Pastikan MySQL di XAMPP sudah aktif dan database <strong>" . DB_NAME . "</strong> sudah ada.</p>";
                echo "</div>";
                exit;
            }
        }
    }
    return $pdo;
}
