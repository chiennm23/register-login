<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post">
    <fieldset>
        <legend>LogIn</legend>
        UserName
        <input type="text" name="user">
        <br><br>
        PassWord
        <input type="text" name="password">
        <br><br>
        <button type="submit" value="LogIn">LogIn</button>
        <button type="submit" value="Register">Register</button>
    </fieldset>
</form>
</body>
</html>
<?php
$path = "data.json";
$arrayList = getData($path);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $us = $_POST['user'];
    $pa = $_POST['password'];
    if ($_POST['act'] == 'LogIn') {
        if (checkUserName($us, $pa)) {
            echo "Chao Mung " . $us;
        } else {
            echo "Tai khoan k hop le ";
        }
    } else if ($_POST['act'] == 'Register') {
        $user = [
            'username' => $us,
            'password' => $pa
        ];
        if (checkAvailable($us, $pa)){
            addUser($user);
            echo 'Dang ky thanh cong';
        } else {
            echo 'Dang ky that bai ' .$us . " da ton tai!";
        }
    }
}

function getAllUsers($filePath)
{
    return getData($filePath);
}

function getData($filePath)
{
    $dataJson = file_get_contents($filePath);
    return json_decode($dataJson);
}

function addUser($user)
{
    $users = $GLOBALS['arrayList'];
    array_push($users, $user);
    saveData($user);
}

function saveData($data)
{
    $jsonData = json_encode($data);
    file_put_contents('data.json', $jsonData);
}

function checkUserName($user, $password)
{
    $arr = $GLOBALS['arrayList'];
    foreach ($arr as $index => $value) {
        if ($value->name == $user || $value->password == $password) {
            return true;
        }
        return false;
    }
}

function checkAvailable($us,$pa)
{
    if ($us == '' || $pa == '') {
        return false;
    }
    $arr = $GLOBALS['arrayList'];
    foreach ($arr as $index => $value) {
        if ($us == $value->username) {
            return false;
        }
    }
}

?>