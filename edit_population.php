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

    // Перевірка, чи передано ID запису для редагування
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Отримання даних про запис з таблиці "population" за ID
        $query = "SELECT * FROM $table WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $populationData = mysqli_fetch_assoc($result);
            $residenceId = $populationData['residence_id'];
            $birthplaceId = $populationData['birthplace_id'];

            $residence_query = "SELECT * FROM residence where id = $residenceId";
            $residence_result = mysqli_query($conn, $residence_query);

            $birthplace_query = "SELECT * FROM birthplace where id = $birthplaceId";
            $birthplace_result = mysqli_query($conn, $birthplace_query);

            $residenceData = mysqli_fetch_assoc($residence_result);
            $birthplaceData = mysqli_fetch_assoc($birthplace_result);

            $PIB = $populationData['PIB'];
            $gender = $populationData['gender'];
            $dateofbirth = $populationData['dateofbirth'];
            $dateofdeath = $populationData['dateofdeath'];
            $marital_status = $populationData['marital_status'];
            $nationality = $populationData['nationality'];
            $phone_number = $populationData['phone_number'];
              
              if ($dateofdeath === NULL) {
                $dateofdeath = '0000-00-00'; // Встановлюємо значення NULL
              }

            // Відображення форми редагування з попередніми значеннями
            echo "
            <h1>Редагувати громадянина</h1>
            <form action='edited_population.php' method='POST'>
                <input type='hidden' name='id' required value='$id'>
                <label>ПІБ:</label>
                <input type='text' name='PIB' required value='$PIB' size='33'><br><br>
                <label>Стать:</label>
                <input type='text' name='gender' value='$gender' required><br><br>
                <label>Дата народження:</label>
                <input type='text' name='dateofbirth' required value='$dateofbirth'><br><br>
                <label>Дата смерті:</label>
                <input type='text' name='dateofdeath' required value=$dateofdeath><br><br>
                <label>Сімейний стан:</label>
                <input type='text' name='marital_status' required value='$marital_status'><br><br>
                <label>Національність:</label>
                <input type='text' name='nationality' required value='$nationality'><br><br>
                <label>Номер телефону:</label>
                <input type='text' name='phone_number' required value='$phone_number'><br><br>
                <input type='hidden' name='residence_id' value='$residenceId'>
                <input type='hidden' name='birthplace_id' value='$birthplaceId'>
                <label>Місце проживання:</label>
                <input type='text' name='city_r' required value='{$residenceData['city_r']}'>
                <input type='text' name='adres_r' required value='{$residenceData['adres_r']}'><br><br>
                <label>Місце народження:</label>
                <input type='text' name='city_b' required value='{$birthplaceData['city_b']}'>
                <input type='text' name='adres_b' required value='{$birthplaceData['adres_b']}'><br><br>
                <input type='submit' value='Зберегти зміни'>
            </form>
            ";
        } else {
            echo "Запис з ID $id не знайдено.";
        }
    }

    // Закрити з'єднання
    $conn->close();
    ?>

</body>
</html>