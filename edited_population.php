<html>
<head>
    <meta charset="utf-8">
    <title>Редагувати громадянина</title>
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

// Перевірка з'єднання з базою даних
if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

// Перевірка, чи дані надійшли з форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $PIB = $_POST['PIB'];
    $gender = $_POST['gender'];
    $dateofbirth = $_POST['dateofbirth'];
    $dateofdeath = $_POST['dateofdeath'];
    $marital_status = $_POST['marital_status'];
    $nationality = $_POST['nationality'];
    $phone_number = $_POST['phone_number'];
    $residenceId = $_POST['residence_id'];
    $birthplaceId = $_POST['birthplace_id'];
    $city_r = $_POST['city_r'];
    $adres_r = $_POST['adres_r'];
    $city_b = $_POST['city_b'];
    $adres_b = $_POST['adres_b'];

    // Оновлення запису в таблиці "population"
    $query = "UPDATE $table SET PIB='$PIB', gender='$gender', dateofbirth='$dateofbirth', 
    dateofdeath= " . ($dateofdeath === '0000-00-00' ? 'NULL' : "'$dateofdeath'") . ", 
    marital_status='$marital_status', nationality='$nationality', phone_number='$phone_number' WHERE id=$id";
    $result = mysqli_query($conn, $query);

    // Оновлення запису в таблиці "residence"
    $residence_query = "UPDATE residence SET city_r='$city_r', adres_r='$adres_r' WHERE id=$residenceId";
    $residence_result = mysqli_query($conn, $residence_query);

    // Оновлення запису в таблиці "birthplace"
    $birthplace_query = "UPDATE birthplace SET city_b='$city_b', adres_b='$adres_b' WHERE id=$birthplaceId";
    $birthplace_result = mysqli_query($conn, $birthplace_query);

    if ($result && $residence_result && $birthplace_result) {
        echo "<b><h1>Запис даних успішно оновлено!</h1></b><p>";
        echo "<script>setTimeout(function(){location.href='population.php'},2000);</script>";

} else {
        echo "<b><h1>Помилка оновлення запису в БД.</h1></b><p>";
        echo "<script>setTimeout(function(){location.href='population.php'},2000);</script>";
    }
}

// Закрити з'єднання
$conn->close();
?>

</body>
</html>