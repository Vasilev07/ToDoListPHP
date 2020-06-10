<?php
    require "db_connection.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main-section"></div>
    <div class="add-section">
        <form action="app/add.php" method="POST">
            <?php if(isset($_GET['message']) && $_GET['message'] == 'error'){ ?>
                    <input type="text" 
                        name="title" 
                        style="border-color: red"
                        placeholder="This field is required" />
                <button type="submit">Add &nbsp; <span>&#43;</span></button>

            <?php }else{ ?>
                <input type="text" 
                        name="title" 
                        placeholder="What do you need to do?" />
                <button type="submit">Add &nbsp; <span>&#43;</span></button>
            <?php } ?>
        </form>
    </div>
    <?php
        $todoes = $conn->query("SELECT * FROM todos");
    ?>
    <div class="show-todo-section">
        <?php if($todoes->rowCount() <= 0){ ?>
            <div class="todo-item">
                <input type="checkbox">
                <h2>Some shit here</h2>
                <br>
                <small>created: today</small>
            </div>
        <?php } ?>

        <?php while($todo = $todoes->fetch(PDO::FETCH_ASSOC)){?>
            <div class="todo-item">
                <span id="<?php echo $todo["id"]; ?>"
                    class="remove-to-do">x</span>
                <?php if($todo["checked"]) {?>
                    <input type="checkbox" data-todo-id="<?php echo $todo["id"]; ?>" class="check-box" checked>
                    <h2 class="checked"><?php echo $todo["title"]; ?></h2>
                <?php } else { ?>
                    <input type="checkbox" data-todo-id="<?php echo $todo["id"]; ?>" class="check-box">
                    <h2><?php echo $todo["title"]; ?></h2>
                <?php } ?>
                <br>
                <small>created: <?php echo $todo["date_time"]; ?></small>
            </div>
        <?php } ?>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".remove-to-do").click(function() {
                const id = $(this).attr('id');
                $.post("app/remove-to-do.php", {
                    id: id
                }, data => {
                    if (data) {
                        $(this).parent().hide(600);
                    }
                });
            });

            $(".check-box").click(function(e) {
                const id = $(this).attr('data-todo-id');

                $.post('app/check.php', {
                    id: id
                }, (data) => {
                    if (data != 'error') {
                        const h2 = $(this).next();
                        if (data == '1') {
                            h2.removeClass('checked');
                        } else {
                            h2.addClass('checked');
                        }
                    }
                })
            });
        });
    </script>
</body>
</html>