<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskTracker</title>
    <link rel="stylesheet" href="public/styles/styles.css">
</head>

<body class="mainPage">
    <header>
        <h1>TaskTracker</h1>
        <nav>
            <ul>
                <li><a href="/tasks">Tasks</a></li>
                <li><a href="#">Calendar</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="tasks">
            <div class="tasks-header">
                <h2>My tasks</h2>
                <a href="/addTask" class="add-task-btn">Add New Task</a>
            </div>
            <?php if (empty($tasks)): ?>
                <div class="task-card">
                    <h3>No tasks found</h3>
                    <p>You don't have any tasks assigned yet. Create your first task!</p>
                </div>
            <?php else: ?>
                <div class="tasks-grid">
                    <?php foreach ($tasks as $task): ?>
                    <a href="/taskDetails?id=<?= $task->getId(); ?>" class="task-link">
                        <div class="task-card">
                            <h3 class="task-card__title"><?= htmlspecialchars($task->getTitle() ?? ''); ?></h3>
                            <p class="task-card__description"><?= htmlspecialchars($task->getDescription() ?? ''); ?></p>
                            <div class="task-card__meta">
                                <?php 
                                $priority = $task->getPriority() ?? 'Medium';
                                $priorityLower = strtolower($priority);
                                ?>
                                <span class="tag <?= $priorityLower ?>"><?= htmlspecialchars($priority); ?></span>
                                <span class="due"><?= htmlspecialchars($task->getDeadline() ?? ''); ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
