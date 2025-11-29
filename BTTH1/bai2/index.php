<?php
// 1. Kết nối MySQL
$host = "localhost";
$user = "root";
$pass = ""; // mật khẩu MySQL
$dbname = "question";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// 2. Lấy câu hỏi từ CSDL
$sql = "SELECT * FROM quizzes";
$result = $conn->query($sql);

$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = [
            'question' => $row['question'],
            'options' => [
                'A' => $row['option_a'],
                'B' => $row['option_b'],
                'C' => $row['option_c'],
                'D' => $row['option_d']
            ],
            'correct' => [ $row['answer'] ]
        ];
    }
}

// 3. Xử lý submit bài
$showResult = false;
$score = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $showResult = true;
    foreach ($questions as $index => $question) {
        $userAnswer = $_POST['answers'][$index] ?? [];
        if (!is_array($userAnswer)) $userAnswer = [$userAnswer];
        sort($userAnswer);
        $correctAnswer = $question['correct'];
        sort($correctAnswer);
        if ($userAnswer == $correctAnswer) $score++;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài thi trắc nghiệm Android</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
        h1 { text-align: center; color: #333; }
        .question { background: white; padding: 15px; margin: 15px 0; border-radius: 5px; }
        .question-text { font-weight: bold; margin-bottom: 10px; }
        .option { margin: 8px 0; }
        .correct { background: #d4edda; }
        .incorrect { background: #f8d7da; }
        .btn { background: #007bff; color: white; padding: 10px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #0056b3; }
        .result { background: #d4edda; padding: 20px; text-align: center; border-radius: 5px; margin-bottom: 20px; }
        .submit { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Bài thi trắc nghiệm Android</h1>
    
    <?php if ($showResult): ?>
        <div class="result">
            <h2>Kết quả: <?php echo $score; ?>/<?php echo count($questions); ?> câu đúng</h2>
            <p>Điểm: <?php echo round(($score / count($questions)) * 100, 2); ?>%</p>
        </div>
    <?php endif; ?>

    <form method="POST">
        <?php foreach ($questions as $index => $question): ?>
            <?php
            $userAnswer = $_POST['answers'][$index] ?? [];
            if (!is_array($userAnswer)) $userAnswer = [$userAnswer];
            ?>
            <div class="question">
                <div class="question-text">Câu <?php echo $index + 1; ?>: <?php echo htmlspecialchars($question['question']); ?></div>
                
                <?php foreach ($question['options'] as $key => $option): ?>
                    <?php
                    $class = '';
                    if ($showResult) {
                        if (in_array($key, $question['correct'])) $class = 'correct';
                        elseif (in_array($key, $userAnswer)) $class = 'incorrect';
                    }
                    ?>
                    <div class="option <?php echo $class; ?>">
                        <input type="radio" 
                               name="answers[<?php echo $index; ?>]" 
                               value="<?php echo $key; ?>"
                               id="q<?php echo $index.$key; ?>"
                               <?php echo in_array($key, $userAnswer) ? 'checked' : ''; ?>
                               <?php echo $showResult ? 'disabled' : ''; ?>>
                        <label for="q<?php echo $index.$key; ?>"><?php echo $key; ?>. <?php echo htmlspecialchars($option); ?></label>
                    </div>
                <?php endforeach; ?>
                
                <?php if ($showResult): ?>
                    <p style="color: green; margin-top: 10px;"><strong>Đáp án đúng: <?php echo implode(', ', $question['correct']); ?></strong></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="submit">
            <?php if (!$showResult): ?>
                <button type="submit" class="btn">Nộp bài</button>
            <?php else: ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn" style="text-decoration: none; display: inline-block;">Làm lại</a>
            <?php endif; ?>
        </div>
    </form>
</body>
</html>
