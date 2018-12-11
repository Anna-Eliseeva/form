<?php

require_once __DIR__ . '/db_connect.php';

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($dbc, htmlspecialchars(trim($_POST['username'])));
    $password1 = mysqli_real_escape_string($dbc, htmlspecialchars(trim($_POST['password1'])));
    $password2 = mysqli_real_escape_string($dbc, htmlspecialchars(trim($_POST['password2'])));
    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
        $query = "
            SELECT `id`, `name`, `password` 
            FROM `signup` 
            WHERE `name` = '{$username}'
        ";
        $data = mysqli_query($dbc, $query);
        if ($data && $data->num_rows === 0) {
            $query = "
                INSERT INTO `signup` (`name`, `password`) 
                VALUES ('{$username}', SHA('{$password2}'))
            ";
            mysqli_query($dbc, $query);
            echo 'Всё готово, можете авторизоваться';
            mysqli_close($dbc);
            header("refresh:1;url=index.php");
            exit();
        } else {
            echo 'Логин уже существует';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <link href="style/style.css" rel="stylesheet">
    <title>Signup</title>
</head>
<body>
<header>
    <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="/">Новости</a></li>
        <li><a href="/">Музыка</a></li>
        <li><a href="/">Обратная связь</a></li>
    </ul>
</header>
<content>
    <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
        <label for="username">Введите ваш логин:</label>
        <input type="text" id="username" name="username">
        <label for="password1">Введите ваш пароль:</label>
        <input type="password" id="password1" name="password1">
        <label for="password2">Введите пароль еще раз:</label>
        <input type="password" id="password2" name="password2">
        <button type="submit" name="submit">Вход</button>
    </form>
</content>
<footer class="clear">
    <p>Все права защищены</p>
</footer>

</body>

</html>