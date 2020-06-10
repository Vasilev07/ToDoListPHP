<?php

if(isset($_POST['id'])) {
    require '../db_connection.php';
    $id = $_POST['id'];

    echo $id;

    if(empty($id)) {
        echo 0;
    } else {
        $sql = $conn->prepare("DELETE FROM todos WHERE id=?");
        $result = $sql->execute([$id]);

        if($result) {
            echo 1;
        } else {
            echo 0;
        }

        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?message=error");
}