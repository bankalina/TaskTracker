<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskDetails</title>
    <link rel="stylesheet" href="public/styles/styles.css">
</head>

<body class="taskDetails">
    <header class="header">
        <h1>TaskTracker</h1>
        <nav class="nav">
            <ul class="nav__list">
                <li class="nav__item"><a href="/tasks" class="nav__link">Tasks</a></li>
                <li class="nav__item"><a href="#" class="nav__link">Calendar</a></li>
                <li class="nav__item"><a href="#" class="nav__link">Reports</a></li>
                <li class="nav__item"><a href="/logout" class="nav__link">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Display error messages -->
    <?php if (isset($messages) && !empty($messages)): ?>
        <div class="message message--error">
            <?php foreach ($messages as $message): ?>
                <p><?= htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <main class="main-content">
        <div class="task-details">
            <?php if (isset($task)): ?>
                <div class="card">
                    <div class="card__header">
                        <h2 class="card__title">Task Details</h2>
                    </div>
                    <div class="card__content">
                        <div class="form-group">
                            <label for="task-title" class="form-label">Task Title</label>
                            <input type="text" id="task-title" class="form-input" value="<?= htmlspecialchars($task->getTitle()); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="task-desc" class="form-label">Description</label>
                            <textarea id="task-desc" class="form-textarea auto-resize" readonly><?= htmlspecialchars($task->getDescription()); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="task-date" class="form-label">Deadline</label>
                            <input type="date" id="task-date" class="form-input" value="<?= htmlspecialchars($task->getDeadline()); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Priority</label>
                            <div class="priority-buttons">
                                <?php 
                                $priority = $task->getPriority() ?? 'Medium';
                                $priorities = ['High', 'Medium', 'Low'];
                                foreach ($priorities as $p): 
                                    $isActive = ($p === $priority) ? 'active' : '';
                                ?>
                                <button type="button" class="priority-btn tag--<?= strtolower($p) ?> <?= $isActive ?>" disabled><?= $p ?></button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="status-display">
                                <span class="status-tag"><?= htmlspecialchars($task->getStatus()); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card__footer">
                        <?php if (isset($canEdit) && $canEdit): ?>
                            <a href="/editTask?id=<?= $task->getId(); ?>" class="edit-btn">Edit Task</a>
                        <?php else: ?>
                            <button type="button" class="edit-btn" onclick="showEditPermissionMessage()">Edit Task</button>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (isset($subtasks) && !empty($subtasks)): ?>
                        <div class="card">
                            <div class="card__header">
                                <h3 class="card__title">Subtasks</h3>
                            </div>
                            <div class="card__content">
                                <div class="subtasks-list">
                                    <?php foreach ($subtasks as $subtask): ?>
                                        <div class="subtask-item">
                                            <h4><?= htmlspecialchars($subtask['title'] ?? ''); ?></h4>
                                            <?php if (!empty($subtask['description'])): ?>
                                                <p><?= htmlspecialchars($subtask['description']); ?></p>
                                            <?php endif; ?>
                                            <div class="subtask-meta">
                                                <?php if (!empty($subtask['status'])): ?>
                                                    <span class="subtask-status">Status: <?= htmlspecialchars($subtask['status']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- User Role Information -->
                    <?php if (isset($userRole)): ?>
                    <div class="user-role-info">
                        <strong>Your role for this task:</strong> 
                        <span class="role-badge"><?= htmlspecialchars($userRole); ?></span>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="message error">Task not found.</div>
                <?php endif; ?>
        </div>
    </main>
    
    <script>
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        function showEditPermissionMessage() {
            alert('You do not have permission to edit this task. Only Owners and Assigned users can edit tasks.');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('task-desc');
            if (textarea) {
                autoResize(textarea);
            }
        });
    </script>
</body>

</html>
