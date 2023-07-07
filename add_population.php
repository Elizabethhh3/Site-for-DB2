<html>
<head>
    <meta charset="utf-8">
    <title>Додати громадянина</title>
</head>

<body>
    <?php

        print "<h1>Додати нового громадянина</h1>";
        
        $db_host = 'localhost'; // хост бази даних
        $db_name = 'census'; // назва бази даних
        $db_user = 'root'; // користувач бази даних
        $db_pass = '123456'; // пароль бази даних
        $table = 'population';

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // Визначаємо id для нового запису
        foreach($conn->query("SELECT MAX(id) FROM $table") as $row) {
          $id = $row['MAX(id)']+1;
        }

        foreach($conn->query("SELECT MAX(residence_id) FROM $table") as $row) {
          $residence_id = $row['MAX(residence_id)']+1;
        }

        foreach($conn->query("SELECT MAX(birthplace_id) FROM $table") as $row) {
          $birthplace_id = $row['MAX(birthplace_id)']+1;
        }

        $PIB = $_POST['PIB'];
        $gender = $_POST['gender'];
        $dateofbirth = $_POST['dateofbirth'];
        $dateofdeath = $_POST['dateofdeath'];
        $marital_status = $_POST['marital_status'];
        $nationality = $_POST['nationality'];
        $phone_number = $_POST['phone_number'];
        $city_r = $_POST['city_r'];
        $city_b = $_POST['city_b'];
        $adres_r = $_POST['adres_r'];
        $adres_b = $_POST['adres_b'];

        $result = $conn->query("INSERT INTO residence (id, city_r, adres_r) VALUES 
        ($residence_id, '$city_r', '$adres_r')");

        $result = $conn->query("INSERT INTO birthplace (id, city_b, adres_b) VALUES 
        ($birthplace_id, '$city_b', '$adres_b')");

// Вставка запису в таблицю population
$result = $conn->query("INSERT INTO population (id, PIB, gender, dateofbirth, dateofdeath, marital_status, nationality, phone_number, residence_id, birthplace_id)
VALUES ($id, '$PIB', '$gender', '$dateofbirth', " . ($dateofdeath === '0000-00-00' ? 'NULL' : "'$dateofdeath'") . ", 
'$marital_status', '$nationality', '$phone_number', $residence_id, $birthplace_id)");

if ($result) {
echo "<b><h1>Запис даних в базу даних виконано успішно!</h1></b><p>";
} else {
echo "<b><h1>Помилка запису даних в базу даних.</h1></b><p>";
}
echo "<script>setTimeout(function(){location.href='population.php'},2000);</script>";
// Закрити з'єднання
$conn->close();
die();
?>

</body>
</html>