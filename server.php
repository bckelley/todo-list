<?PHP

require "./db/config.php";

session_start();
$db = new DB("localhost", "root", "", "accounts");

$task = "";
$id = 0;
$update = false;

if (isset($_POST['save'])) {
    $task = $_POST['task'];

    $data = ['task' => $task];
    $insertId = $db->insert("`todo-tasks`", $data);

    if ($insertId) {
        $_SESSION['message'] = "Task Added";
    }

    header('Location: index.php');
}

if ( isset($_POST['action']) && $_POST['action'] === 'update' ) {
    $taskId = $_POST['taskId'];
    $isCompleted = isset($_POST['isCompleted']) === 'true' ? 1 : 0;
    
    $data = ['isCompleted' => $isCompleted];
    $cond = ['id' => $taskId];
    
    $updateRow = $db->update("`todo-tasks`", $data, $cond);
    if ($updateRow) {
        $_SESSION['message'] = "Task Status Updated!";
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];

    $data = ['task' => $task];
    $cond = ['id' => $id];
    $updateRow = $db->update("`todo-tasks`", $data, $cond);

    if ($updateRow) {
        $_SESSION['message'] = "Task Updated!";
    }

    header('location: index.php');
    exit();
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    // mysqli_query($db, "DELETE FROM tasks WHERE id='$id'");
    $_SESSION['message'] = "Task Removed!";
    header('Location: index.php');
}