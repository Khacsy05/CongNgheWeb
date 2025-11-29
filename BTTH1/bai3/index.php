<?php
// Thông tin kết nối
$host = "localhost";
$user = "root";
$pass = ""; // nếu dùng XAMPP thường để trống
$dbname = "thi";

// Kết nối MySQL
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn dữ liệu từ bảng Students
$sql = "SELECT * FROM Students";
$result = $conn->query($sql);

// Lưu dữ liệu vào mảng
$data = [];
$headers = [];
if ($result && $result->num_rows > 0) {
    $headers = array_keys($result->fetch_assoc()); // lấy tên cột
    $result->data_seek(0); // reset con trỏ dữ liệu
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tài khoản sinh viên</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; text-align: center; }
        .stats { background: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #2196F3; color: white; padding: 12px; text-align: left; position: sticky; top: 0; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f5f5f5; }
        tr:nth-child(even) { background: #fafafa; }
        .error { background: #ffebee; color: #c62828; padding: 15px; border-radius: 5px; text-align: center; }
        .btn { background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 Danh sách tài khoản sinh viên</h1>
        
        <?php if (empty($data)): ?>
            <div class="error">
                ⚠️ Không tìm thấy dữ liệu trong bảng Students!
            </div>
        <?php else: ?>
            <div class="stats">
                <strong>Tổng số tài khoản:</strong> <?php echo count($data); ?> | 
                <strong>Số cột:</strong> <?php echo count($headers); ?>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <?php foreach ($headers as $header): ?>
                            <th><?php echo htmlspecialchars($header); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <?php foreach ($row as $cell): ?>
                                <td><?php echo htmlspecialchars($cell); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top: 20px; text-align: center;">
                <button class="btn" onclick="window.location.reload()">🔄 Tải lại</button>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
