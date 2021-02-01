<!DOCTYPE html>
<html lang="en">
<head>
    <link href="styles/loginStyle.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
</head>
<body>
    <form action="<?= ($_SERVER['PHP_SELF']); ?>" method="POST" >
        <div class = 'loginContainer'>
        <h3>Вход в админ-панель</h3>
        <div class = 'loginElem'>
            <input type="text" name="username" placeholder="Имя пользователя">
        </div>
        <div class = 'loginElem'>
            <input type="password" name="password" placeholder="Пароль">
        </div>
        <div class = 'loginElem'>
            <button type="submit">Войти</button>
        </div>
        <a id= 'backBottom' href="index.php">Назад</a>
        </div>
    </form>
</body>
</html>

