<?php
// ======================= CONTROLLER =======================
// Là "não" của ứng dụng

// TODO 6: Import Model
require_once 'models/SinhVienModel.php';

// === THIẾT LẬP KẾT NỐI PDO ===
$host = '127.0.0.1';
$dbname = 'cse485_web';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
// === KẾT THÚC KẾT NỐI PDO ===


// TODO 8: Kiểm tra hành động submit form
if (isset($_POST['ten_sinh_vien']) && isset($_POST['email'])) {

    // TODO 9: Lấy dữ liệu từ form
    $ten = $_POST['ten_sinh_vien'];
    $email = $_POST['email'];

    // TODO 10: Gọi Model để thêm sinh viên
    addSinhVien($pdo, $ten, $email);

    // TODO 11: Redirect để tránh thêm lại khi F5
    header('Location: index.php');
    exit;
}

// TODO 12: Lấy danh sách sinh viên
$danh_sach_sv = getAllSinhVien($pdo);

// TODO 13: Gọi View để hiển thị giao diện
include 'views/sinhvien_view.php';
?>
