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
                <li><a href="/tasks">Tasks</a></li>
                <li><a href="#">Calendar</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Display error messages -->
    <?php if (isset($messages) && !empty($messages)): ?>
        <div class="message error">
            <?php foreach ($messages as $message): ?>
                <p><?= htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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
                    <textarea id="task-desc" readonly class="auto-resize"><?= htmlspecialchars($task->getDescription()); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="task-date">Deadline</label>
                    <input type="date" id="task-date" value="<?= htmlspecialchars($task->getDeadline()); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <div class="priority-buttons">
                        <?php 
                        $priority = $task->getPriority() ?? 'Medium';
                        $priorities = ['High', 'Medium', 'Low'];
                        foreach ($priorities as $p): 
                            $isActive = ($p === $priority) ? '' : 'priority-disabled';
                        ?>
                        <button class="<?= strtolower($p) ?> <?= $isActive ?>"><?= $p ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="status-display">
                        <span class="status-tag"><?= htmlspecialchars($task->getStatus()); ?></span>
                    </div>
                </div>
                    <div class="buttons">
                        <?php if (isset($canEdit) && $canEdit): ?>
                            <a href="/editTask?id=<?= $task->getId(); ?>" class="edit-btn">Edit Task</a>
                        <?php else: ?>
                            <button type="button" class="edit-btn" onclick="showEditPermissionMessage()">Edit Task</button>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (isset($subtasks) && !empty($subtasks)): ?>
                        <div class="subtasks-section">
                            <h3>Subtasks</h3>
                            <div class="subtasks-list">
                                <?php foreach ($subtasks as $subtask): ?>
                                    <div class="subtask-item">
                                        <div class="subtask-content">
                                            <h4><?= htmlspecialchars($subtask['title'] ?? ''); ?></h4>
                                            <?php if (!empty($subtask['description'])): ?>
                                                <p><?= htmlspecialchars($subtask['description']); ?></p>
                                            <?php endif; ?>
                                            <div class="subtask-meta">
                                                <?php if (!empty($subtask['status'])): ?>
                                                    <span class="subtask-status">Status: <?= htmlspecialchars($subtask['status']); ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($subtask['created_at'])): ?>
                                                    <span class="subtask-date">Created: <?= date('Y-m-d', strtotime($subtask['created_at'])); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
