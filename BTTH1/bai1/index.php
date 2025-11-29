<?php include 'flowers.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Danh sách các loài hoa</title>
    <style>
        .flower-box {
            width: 900px;
            margin: 20px auto;
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }
        .flower-box img {
            width: 100%;
            border-radius: 8px;
        }
        h2 {
            margin: 10px 0 5px 0;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Các Loài Hoa</h1>

<?php foreach ($flowers as $flower): ?>
    <div class="flower-box">
        <img src="images/<?= $flower['image'] ?>" alt="<?= $flower['name'] ?>">
        <h2><?= $flower['name'] ?></h2>
        <p><?= $flower['description'] ?></p>
    </div>
<?php endforeach; ?>

</body>
</html>
