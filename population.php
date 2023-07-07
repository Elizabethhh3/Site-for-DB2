<html>
<head>
    <meta charset='utf-8'>
    <title>Список населення</title>
</head>

<body>
<h1>Список населення</h1>
    <a href='index.php'>🢠 На головну</a><p>
    <a href='add_population.html'>➕Додати запис</a> <p> <a href='search_population.php'>🔍Пошук записів</a>
    <?php
        $db_host = 'localhost'; // хост бази даних
        $db_name = 'census'; // назва бази даних
        $db_user = 'root'; // користувач бази даних
        $db_pass = '123456'; // пароль бази даних
        $table = 'population';

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // Перевірка з'єднання з базою даних
        if ($conn->connect_error) {
            die("Помилка з'єднання з базою даних: " . $conn->connect_error);
        }

        $sql = "SELECT r.id, r.PIB, r.gender, r.dateofbirth, r.dateofdeath, r.marital_status, r.nationality, r.phone_number, 
            CONCAT_WS(', ', res.city_r, res.adres_r) AS residence, CONCAT_WS(', ', bir.city_b, bir.adres_b) AS birthplace 
            FROM population r
            LEFT JOIN residence res ON r.residence_id = res.id
            LEFT JOIN birthplace bir ON r.birthplace_id = bir.id";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            // Виводимо дані кожного запису у вигляді таблиці
            print "<table>";
            print "<tr>";
            print "<th>ID</th>";
            print "<th>ПІБ</th>";
            print "<th>Стать</th>";
            print "<th>Дата народження</th>";
            print "<th>Дата смерті</th>";
            print "<th>Сімейний стан</th>";
            print "<th>Національність</th>";
            print "<th>Номер телефону</th>";
            print "<th>Місце проживання</th>";
            print "<th>Місце народження</th>";
            print "<th>Редагувати</th>";
            print "<th>Видалити</th>";
            print "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                $residence = $row["residence"];
                $birthplace = $row["birthplace"];
                print "<tr>";
                print "<td>" . $row['id'] . "</td>";
                print "<td>" . $row['PIB'] . "</td>";
                print "<td>" . $row['gender'] . "</td>";
                print "<td>" . $row['dateofbirth'] . "</td>";
                print "<td>" . $row['dateofdeath'] . "</td>";
                print "<td>" . $row['marital_status'] . "</td>";
                print "<td>" . $row['nationality'] . "</td>";
                print "<td>" . $row['phone_number'] . "</td>";
                print "<td>" . $row['residence'] . "</td>";
                print "<td>" . $row['birthplace'] . "</td>";
                print "<td><a href='edit_population.php?id=" . $row['id'] . "'>✍️Редагувати</td>";
                print "<td><a href='delete_population.php?id=" . $row['id'] . "'>❌Видалити</td></tr>";
}
print "</table>";
} else {
echo "Немає результатів.";
}
mysqli_close($conn);
?>
<div class="add-button-container">
    <a href="add_client.php" class="add-button">Додати новий запис</a>
</div>

</body>
</html>