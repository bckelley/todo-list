<?PHP

session_start();
$db = mysqli_connect('localhost', 'root', 'admin', 'todo');

$task = "";
$id = 0;
$update = false;

if (isset($_POST['save'])) {
    $task = $_POST['task'];

    mysqli_query($db, "INSERT INTO tasks (task) VALUES ($tasks)");

    $_SESSION['message'] = "Task Added";
    header('Location: index.php');
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];

    mysqli_query($db, "UPDATE tasks SET task='$task' WHERE id='$id'");

    $_SESSION['message'] = "Task Updated!";
    header('location: index.php');
}
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE FROM tasks WHERE id='$id'");
    $_SESSION['message'] = "Task Removed!";
    header('Location: index.php');
}