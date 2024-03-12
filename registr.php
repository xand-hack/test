<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        echo "Пароли не совпадают";
    } else {
        $sql = "SELECT * FROM users WHERE email='$email' OR phone='$phone'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Пользователь с таким email/телефоном уже существует";
        } else {
            $insertsql = "INSERT INTO users (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$password')";
            if ($conn->query($insertsql) === TRUE) {
                echo "Вы зарегистрировались";
            } else {
                echo "Ошибка: " . $insertsql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Имя: <input type="text" name="name"required><br>
        Телефон: <input type="text" name="phone" required><br>
        Email: <input type="text" name="email"required><br>
        Пароль: <input type="password" name="password"required><br>
        Повторите пароль: <input type="password" name="password2"required><br>
        <input type="submit" value="Зарегистрироваться">
    </form>
</body>
</html>