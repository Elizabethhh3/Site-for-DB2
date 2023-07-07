<html>
<head>
    <meta charset="utf-8">
    <title>Видалити громадянина</title>
    <style>
        body { text-align: center;
        }
    </style>
</head>

<body>
    <?php
          $db_host = 'localhost'; // хост бази даних
          $db_name = 'census'; // назва бази даних
          $db_user = 'root'; // користувач бази даних
          $db_pass = '123456'; // пароль бази даних
          $table = 'population';

        // Створити з'єднання
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        
        $id = $_GET["id"];

        // Отримання інформації про запис з таблиці "population" за ID
    $populationQuery = "SELECT * FROM $table WHERE id = $id";
    $populationResult = mysqli_query($conn, $populationQuery);

if ($populationResult && mysqli_num_rows($populationResult) > 0) {
    $populationData = mysqli_fetch_assoc($populationResult);
    $residenceId = $populationData['residence_id'];
    $birthplaceId = $populationData['birthplace_id'];

    // Видалення запису з таблиці "population"
    $conn->query("DELETE FROM $table WHERE id = $id");

    // Видалення запису з таблиці "residence" за відповідним ID
    $conn->query("DELETE FROM residence WHERE id = $residenceId");

    // Видалення запису з таблиці "birthplace" за відповідним ID
    $conn->query("DELETE FROM birthplace WHERE id = $birthplaceId");

    echo "<b><h1>Готово!</h1></b><p>";
    echo "<script>setTimeout(function(){location.href='population.php'},2000);</script>";
} else {
    echo "Помилка: запис не знайдено.";
}
        
        // Закрити з'єднання
        die();
    ?>
    
</body>
</html>