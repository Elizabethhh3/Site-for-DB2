<html>
<head>
    <meta charset="utf-8">
    <title>Пошук записів</title>
</head>

<body>
<h1>Пошук записів</h1>
<a href='population.php'>🢠 Список населення</a><p>
<?php

$db_host = 'localhost'; // хост бази даних
$db_name = 'census'; // назва бази даних
$db_user = 'root'; // користувач бази даних
$db_pass = '123456'; // пароль бази даних
$table = 'population';

// Перевірка, чи дані надійшли з форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST['search_term'];

    // Створення з'єднання з базою даних
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Перевірка з'єднання з базою даних
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних." . $conn->connect_error);
    }

    // Підготовка запиту до бази даних для пошуку громадянина за ПІБ
    $query = "SELECT * FROM $table WHERE PIB LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);

    // Перевірка результату запиту
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h2>Результати пошуку:</h2>";

        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>ПІБ</th>";
        echo "<th>Стать</th>";
        echo "<th>Дата народження</th>";
        echo "<th>Дата смерті</th>";
        echo "<th>Сімейний стан</th>";
        echo "<th>Національність</th>";
        echo "<th>Номер телефону</th>";
        echo "<th>Місце проживання</th>";
        echo "<th>Місце народження</th>";
        print "<th>Редагувати</th>";
        print "<th>Видалити</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $PIB = $row['PIB'];
            $gender = $row['gender'];
            $dateofbirth = $row['dateofbirth'];
            $dateofdeath = $row['dateofdeath'];
            $marital_status = $row['marital_status'];
            $nationality = $row['nationality'];
            $phone_number = $row['phone_number'];

            $residenceId = $row['residence_id'];
            $birthplaceId = $row['birthplace_id'];

            // Отримання даних про місце проживання
            $residence_query = "SELECT * FROM residence WHERE id = $residenceId";
            $residence_result = mysqli_query($conn, $residence_query);
            $residenceData = mysqli_fetch_assoc($residence_result);
            $residenceCity = $residenceData['city_r'];
            $residenceAddress = $residenceData['adres_r'];
            
            // Отримання даних про місце народження
            $birthplace_query = "SELECT * FROM birthplace WHERE id = $birthplaceId";
            $birthplace_result = mysqli_query($conn, $birthplace_query);
            $birthplaceData = mysqli_fetch_assoc($birthplace_result);
            $birthplaceCity = $birthplaceData['city_b'];
            $birthplaceAddress = $birthplaceData['adres_b'];
            
            echo "<tr>";
            echo "<td>" . $id . "</td>";
            echo "<td>" . $PIB . "</td>";
            echo "<td>" . $gender . "</td>";
            echo "<td>" . $dateofbirth . "</td>";
            echo "<td>" . $dateofdeath . "</td>";
            echo "<td>" . $marital_status . "</td>";
            echo "<td>" . $nationality . "</td>";
            echo "<td>" . $phone_number . "</td>";
            echo "<td>" . $residenceCity . ", " . $residenceAddress . "</td>";
            echo "<td>" . $birthplaceCity . ", " . $birthplaceAddress . "</td>";
            print "<td><a href='edit_population.php?id=" . $row['id'] . "'>✍️Редагувати</td>";
            print "<td><a href='delete_population.php?id=" . $row['id'] . "'>❌Видалити</td></tr>";
            }
            
            echo "</table>";
            } else {
            echo "Немає результатів.";
            }
            
            // Закриття з'єднання з базою даних
            $conn->close();
            }
            ?>
            
            <!-- HTML форма для введення ПІБ для пошуку -->
            <form action="" method="POST">
            <br><label>ПІБ: </label>
                <input type="text" name="search_term" placeholder="Введіть ПІБ" required>
                <input type="submit" value="Пошук"><br><br>
            </form>
            
            </body>
            </html>
            