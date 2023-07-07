<html>
<head>
    <meta charset="utf-8">
    <title>Головна</title>
</head>

<body>
    <h1>Перепис населення</h1>
    <b> <a href="population.php"> 1. Список населення </a><br>

    <h3><p> Число відвідувань сайту:
    <?php
// З'єднання з базою даних
$mysqli = new mysqli("localhost", "root", "123456", "census");

// Отримання IP-адреси відвідувача
$ip_address = $_SERVER['REMOTE_ADDR'];

// Вставка запису до таблиці
$mysqli->query("INSERT INTO visits (ip_address) VALUES ('$ip_address')");

$result = $mysqli->query("SELECT COUNT(*) FROM visits");
$row = $result->fetch_row();
$total_visits = $row[0];

// Відображення кількості відвідувань на сторінці
echo "$total_visits";
?>

</h3>
</body>
</html>
