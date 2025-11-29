<?php include 'flowers.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản trị hoa</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .btn {
            padding: 5px 10px;
            background: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-delete {
            background: red;
        }
    </style>
</head>
<body>

<h1 style="text-align:center">Quản trị danh sách hoa</h1>

<table>
    <tr>
        <th>STT</th>
        <th>Ảnh</th>
        <th>Tên hoa</th>
        <th>Mô tả</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($flowers as $index => $flower): ?>
    <tr>
        <td><?php echo $index + 1; ?></td>
        <td><img src="images/<?php echo $flower['image']; ?>"></td>
        <td><?php echo $flower['name']; ?></td>
        <td><?php echo $flower['description']; ?></td>
        <td>
            <a href="#" class="btn">Sửa</a>
            <a href="#" class="btn btn-delete">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
