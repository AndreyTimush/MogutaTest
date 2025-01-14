<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <form action="" method="GET">
        <label>Введите искомый E-mail:</label>
        <input value="<?php if (isset($_GET['email'])) echo $_GET['email'] ?>" name='email'>
        <button type='submit'>Искать</button>
    </form>
    <?php
    if (!empty($_GET)) {
        $email = $_GET['email'];

        $mysqli = new mysqli("localhost", "user", "password", "dbname");

        $sql = "SELECT user.id, user_info.name, user_info.sname 
                FROM user
                JOIN user_info ON user.id = user_info.user_id 
                WHERE user.email = ?";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p class='found'>$email - {$row['name']} {$row['sname']} [id = {$row['id']}]</p>";
            }
        } else {
            echo "<p class='notFound'>Записей для email $email не обнаружено!</p>";
        }

        $stmt->close();
        $mysqli->close();
    }
    ?>
</body>

</html>