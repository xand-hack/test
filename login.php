<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $captcha_response = $_POST['captcha_response'];
    $secret_key = ''; //ключ

    $url = 'https://captcha.yandex.net/checkcaptcha';
    $data = [
        'key' => $secret_key,
        'captcha' => $captcha_response
    ];
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $captcha_result = json_decode($result);

    if ($captcha_result->valid) {
        $sql = "SELECT * FROM users WHERE (email='$login' OR phone='$login') AND password='$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            header("Location: profile.php?user_id=" . $user['id']);
            exit();
        } else {
            echo "Неверный email/телефон или пароль";
        }
    } else {
        echo "Пожалуйста, пройдите капчу корректно.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <script src="https://captcha.yandex.net/yaca.js" async></script>
</head>
<body>
    <h2>Авторизация</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        Email/Телефон: <input type="text" name="login" required><br>
        Пароль: <input type="password" name="password" required><br>
        <div class="g-recaptcha" data-sitekey=""></div>
        <input type="submit" value="Войти">
    </form>
</body>
</html>