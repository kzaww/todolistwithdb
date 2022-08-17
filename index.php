<?php
$errors = "";


$db = mysqli_connect('localhost','root','','todo');
if(!$db){
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $task = $_POST['task'];

    if (empty($task)) {
        $errors = "You must fill the task";
    }else{
        mysqli_query($db,"INSERT INTO tasks (task) VALUES ('$task')");
        header('location: todolist.php');
    }

}

//delete task

if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    mysqli_query($db,"DELETE FROM tasks WHERE id=$id");
    header('location:todolist.php');
}

//done task

if (isset($_GET['done_task'])) {
    $id = $_GET['done_task'];
    mysqli_query($db,"UPDATE tasks SET done=1 WHERE id=$id");
    header('location:todolist.php');
}

$tasks = mysqli_query($db,"SELECT * FROM tasks");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color:rgb(0, 0, 0, 0.2);">
    <header>
        <h1>To Do List For Today</h1>
    </header>

    <form action="todolist.php" method="POST">
        <?php if (isset($errors)){ ?>
            <p><?php echo $errors; ?></p>
        <?php  }  ?>
        <input type="text" name="task" placeholder="..." autofocus>
        <button type="submit" name="submit" class="add">Submit</button>
    </form>

    

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Task</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while($row = mysqli_fetch_array($tasks)){?>
                <tr  style='<?php echo $row['done']==1 ? 'background-color:rgb(107, 194, 107, 0.4);':"" ?>'>
                    <td class="id"><?php echo $i; ?></td>
                    <td class="text"><?php echo $row['task']; ?></td>
                    <td class="work">
                        <a href="todolist.php ? done_task=<?php echo $row['id'] ?>" class="done" style='<?php echo $row['done']==1 ? "display:none;":"" ?>'>done</a>
                        <a href="todolist.php ? del_task=<?php echo $row['id'] ?>" class="del">x</a>
                    </td>
                </tr>
                
            <?php $i++; } ?>

        </tbody>
    </table>
</body>
</html>