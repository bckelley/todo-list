<?PHP include 'server.php';
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $update = true;
        $row = $db->getRows("`todo-tasks`", ['where' => ['id' => $id]]);
        if ( $row ) {
            
            foreach ( $row as $r ) {
                $task = $r['task'];
            }
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

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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
        <?PHP $row = $db->getRows("`todo-tasks`"); ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <?PHP if ($row) { ?>
        <tbody>
            <?PHP foreach ($row as $r) { ?>
                <tr>
                    <td><?PHP echo $r['id']; ?></td>
                    <td>
                        <span class="task-list" data-id="<?PHP echo $r['id']; ?>" data-complete="<?PHP echo $r['isCompleted']? 'true': 'false' ?>">
                            <?PHP echo $r['task']; ?>
                        </span>
                    </td>
                    <td class="btn-group">
                        <a href="index.php?edit=<?PHP echo $r['id']; ?>" class="edit_btn">Edit</a>
                        <a href="server.php?del=<?PHP echo $r['id']; ?>" class="del_btn">Delete</a>
                    </td>
                </tr>
            <?PHP } ?>
        <?PHP } else { ?>
            <tr><td colspan='4'>No tasks available.</td>
        <?PHP } ?>
        </tbody>
    </table>
</body>

<script>

    $(document).ready(() => {

        var element  = $('.task-list');
        element.each(function() {
          if ($(this).attr('data-complete') === 'true') {
            $(this).addClass('strike');
          }
        });

        $('.task-list').click((e) => {
            // $(e.target).toggleClass('strike');

            const element       = $(e.target);
            const taskId        = element.data('id');
            const isComplete    = element.data('complete');

            console.info(`Task ID: ${taskId}, Is Complete: ${isComplete}`);

            // Toggle the strike class on the task list item.
            element.toggleClass('strike');
            
            const isCompleted = isComplete ? false : true;
            // const isCompleted = element.hasClass('strike') ? false : true;

            // Update the data attribute
            element.data('complete', isCompleted);
            // element.attr('data-complete', isCompleted);

            // Send a request to update the database.
            $.ajax({
                url: 'server.php',
                method: 'POST',
                data: {
                    action: 'update',
                    taskId: taskId,
                    isCompleted: isCompleted
                },
                success: (res) => {
                    console.info('Updated task', res);
                },
                error: (error) => {
                    console.error("Error updating task", error);
                }
            })

            console.info(`Task ID: ${taskId}, Is Completed: ${isCompleted}`);
        });

    });

</script>

</html>