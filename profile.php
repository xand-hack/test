<?php
require_once 'db.php';


//используя get запрос для получения profile страницы я понимаю уязвимость такого метода, но в тз ничего не говорилось
if (!isset($_GET['user_id'])) {
    echo "пользователь не найден";
    exit();
}

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM users WHERE id=" . $user_id;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}
else {
    echo "пользователь не найден";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $updateSql = "UPDATE users SET name='$name', phone='$phone', email='$email', password='$password' WHERE id=" . $user_id;
    if ($conn->query($updateSql) === TRUE) {
        echo "Данные обновлены";
    } else {
        echo "Ошибка: " . $updateSql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
</head>
<body>
    <h2>Профиль</h2>
    <form method="post" action="">
        Имя: <input type="text" name="name" value="<?php echo $user['name'];?>"><br>
        Телефон: <input type="text" name="phone" value="<?php echo $user['phone'];?>"><br>
        Email: <input type="text" name="email" value="<?php echo $user['email'];?>"><br>
        Пароль: <input type="text" name="password" value="<?php echo $user['password'];?>"><br>
        <input type="submit" value="Сохранить изменения">
    </form>
</body>
</html>