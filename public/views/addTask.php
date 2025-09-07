<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddTask</title>
    <link rel="stylesheet" href="public/styles/styles.css">
</head>

<body class="addTask">
    <header>
        <h1>TaskTracker</h1>
    </header>
    <main>
        <div class="container">
            <form method="POST" action="/addTask">
                <h2>Add new task</h2>

                <div class="form-group">
                    <label for="task-title">Task title</label>
                    <input type="text" id="task-title" name="title" placeholder="Enter the title of the task">
                </div>

                <div class="form-group">
                    <label for="task-desc">Description</label>
                    <textarea id="task-desc" name="description" placeholder="Enter a description of the task"></textarea>
                </div>

                <div class="form-group">
                    <label for="task-date">Deadline</label>
                    <input type="date" id="task-date" name="deadline">
                </div>

                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority" required>
                        <option value="High">High</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="Low">Low</option>
                    </select>
                </div>

                <div class="buttons">
                    <button type="reset" class="delete">Delete</button>
                    <button type="submit" class="save">Save</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
