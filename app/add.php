<?php

if(isset($_POST['title'])) {
    require '../db_connection.php';
    $title = $_POST['title'];

    echo $title;

    if(empty($title)) {
        header("Location: ../index.php?message=error");
    } else {
        $sql = $conn->prepare("INSERT INTO todos(title) VALUE(?)");
        $result = $sql->execute([$title]);

        if($result) {
            header("Location: ../index.php?message=success");
        } else {
            header("Location: ../index.php");
        }

        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?message=error");
}