<?php

if(isset($_POST['id'])) {
    require '../db_connection.php';
    $id = $_POST['id'];

    echo $id;

    if(empty($id)) {
        echo 'error';
    } else {
        $todos = $conn->prepare("SELECT id, checked FROM todos WHERE id=?");
        $todos->execute([$id]);

        $todo = $todos->fetch();
        $uId = $todo['id'];
        $checked = $todo['checked'];

        $uChecked = $checked ? 0 : 1;

        $result = $conn->query("UPDATE todos SET checked=$uChecked WHERE id=$uId");

        if($result) {
            echo $checked;
        } else {
            echo "error";
        }

        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?message=error");
}