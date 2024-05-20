<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
        }
        .card-header {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .card-body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            font-size: 15px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }
        .btn-primary {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .list-group {
            list-style: none;
            padding: 0;
        }
        .list-group-item {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        /* Corrected class name */
        .card.mt-4 {
            /* Added margin-top style */
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <div class="card">
            <div class="card-header">Add a new task</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="task" placeholder="Enter your task here">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>

        <!-- Corrected class name -->
        <div class="card mt-4">
            <div class="card-header">Tasks</div>
            <ul class="list-group list-group-flush">
                <?php
                session_start();

                $todoList = isset($_SESSION["todoList"]) ? $_SESSION["todoList"] : array();

                function appendData($task) {
                    global $todoList;
                    $todoList[] = $task;
                    return $todoList;
                }

                function deleteData($task) {
                    global $todoList;
                    foreach ($todoList as $index => $taskName) {
                        if ($taskName === $task) {
                            unset($todoList[$index]);
                            $todoList = array_values($todoList); // Reindex array
                            break;
                        }
                    }
                    return $todoList;
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["task"])) {
                        echo '<script>alert("Error: Please enter a task.")</script>';
                    } else {
                        $todoList = appendData($_POST["task"]);
                        $_SESSION["todoList"] = $todoList;
                    }
                }

                if (isset($_GET['task'])) {
                    $todoList = deleteData($_GET['task']);
                    $_SESSION["todoList"] = $todoList;
                }

                foreach ($todoList as $task) {
                    echo '<li class="list-group-item">' . htmlspecialchars($task) . '<a href="?delete=true&task=' . urlencode($task) . '" class="btn btn-danger">Delete</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
