<?php
header('Content-Type: text/html; charset=utf-8');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем и очищаем данные
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Валидация
    if (empty($name)) {
        $errors[] = "Введите ваше имя";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введите корректный email";
    }
    if (empty($message)) {
        $errors[] = "Введите сообщение";
    }

    // Если ошибок нет — отправляем письмо
    if (empty($errors)) {
        $to = "garmaeva439@gmail.com";
        $subject = "Сообщение с сайта Solux Hotel Valencia";

        $body = "Получено новое сообщение:\n\n";
        $body .= "Имя: $name\n";
        $body .= "Email: $email\n";
        $body .= "Сообщение:\n$message\n";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $success = true;
        } else {
            $errors[] = "Ошибка отправки. Попробуйте позже.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Результат отправки</title>
</head>
<body>
    <?php if ($success): ?>
        <h3 style="color: green;">Спасибо за сообщение!</h3>
        <p>Мы свяжемся с вами в ближайшее время.</p>
        <a href="index.html">Вернуться на главную</a>
    <?php elseif (!empty($errors)): ?>
        <h3 style="color: red;">Ошибка при отправке:</h3>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="javascript:history.back()">Вернуться и исправить</a>
    <?php endif; ?>
</body>
</html>
