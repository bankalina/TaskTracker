<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskDetails</title>
    <link rel="stylesheet" href="public/styles/styles.css">
</head>

<body class=taskDetails>
    <header>
        <h1>TaskTracker</h1>
        <nav>
            <ul>
                <li><a href="/tasks">← Back to Tasks</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Task Details</h2>
            
            <?php if (isset($messages)): ?>
                <div class="messages">
                    <?php foreach ($messages as $message): ?>
                        <div class="message error"><?= $message ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($task)): ?>
                <div class="form-group">
                    <label for="task-title">Task Title</label>
                    <input type="text" id="task-title" value="<?= htmlspecialchars($task->getTitle()); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="task-desc">Description</label>
                    <textarea id="task-desc" readonly><?= htmlspecialchars($task->getDescription()); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="task-date">Deadline</label>
                    <input type="date" id="task-date" value="<?= htmlspecialchars($task->getDeadline()); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <div class="priority-display">
                        <?php 
                        $priority = $task->getPriority() ?? 'Medium';
                        $priorityLower = strtolower($priority);
                        ?>
                        <span class="tag <?= $priorityLower ?>"><?= htmlspecialchars($priority); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="status-display">
                        <span class="status-tag"><?= htmlspecialchars($task->getStatus()); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Task ID</label>
                    <input type="text" value="<?= htmlspecialchars($task->getId()); ?>" readonly>
                </div>
            <?php else: ?>
                <div class="message error">Task not found.</div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>
