<?PHP include 'server.php';
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $update = true;
        $record = mysqli_query($db, "SELECT * FROM tasks WHERE id=".$id);
        if ( $record ) {
            $n = mysqli_fetch_array($record);
            $task = $n['task'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Document</title>
</head>
<body>
    <h2>ToDo List</h2>
    <?PHP if (isset($_SESSION['message'])): ?>
    <div class="msg">
        <?PHP echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
    <?PHP endif; ?>
    <form action="server.php" method="post">

        <div class="input-group">
            <input type="hidden" name="id" value="<?PHP echo $id ?>" />
        </div>
        <div class="input-group">
            <label for="task">Task</label>
            <input type="text" name="task" value="<?PHP echo $task ?>" />
        </div>
        <div class="input-group">
            <?PHP if ($update == true): ?>
                <button class="btn" type="submit" name="update">Update</button>
            <?PHP else: ?>
                <button class="btn" type="submit" name="save">Save</button>
            <?PHP endif; ?>
        </div>

    </form>
        <?PHP $results = mysqli_query($db, "SELECT * FROM tasks"); ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <?PHP while($row = mysqli_fetch_array($results)) { ?>
        <tbody>
            <tr>
                <td><?PHP echo $row['id']; ?></td>
                <td><?PHP echo $row['task']; ?></td>
                <td>
                    <a href="index.php?edit=<?PHP echo $row['id']; ?>" class="edit_btn">Edit</a>
                </td>
                <td>
                    <a href="server.php?del=<?PHP echo $row['id']; ?>" class="del_btn">Delete</a>
                </td>
            </tr>
        <?PHP } ?>
        </tbody>
    </table>
</body>
</html>