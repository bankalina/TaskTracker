<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="public/styles/styles.css">
</head>

<body class="editTask">
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
        <div class="container">
            <h2>Edit Task</h2>
            
            <?php if (isset($messages)): ?>
                <div class="messages">
                    <?php foreach ($messages as $message): ?>
                        <div class="message error"><?= $message ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($task)): ?>
                <form method="POST" action="/editTask?id=<?= htmlspecialchars($task->getId()); ?>">
                    <input type="hidden" name="task_id" value="<?= htmlspecialchars($task->getId()); ?>">
                    
                    <div class="form-group">
                        <label for="task-title">Task Title</label>
                        <input type="text" id="task-title" name="title" value="<?= htmlspecialchars($task->getTitle()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="task-desc">Description</label>
                        <textarea id="task-desc" name="description" class="auto-resize" required><?= htmlspecialchars($task->getDescription()); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="task-date">Deadline</label>
                        <input type="date" id="task-date" name="deadline" value="<?= htmlspecialchars($task->getDeadline()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Priority</label>
                        <div class="priority-buttons">
                            <?php 
                            $priority = $task->getPriority() ?? 'Medium';
                            $priorities = ['High', 'Medium', 'Low'];
                            foreach ($priorities as $p): 
                                $isActive = ($p === $priority) ? 'active' : '';
                            ?>
                            <button type="button" class="priority-btn tag--<?= strtolower($p) ?> <?= $isActive ?>" data-priority="<?= $p ?>"><?= $p ?></button>
                            <?php endforeach; ?>
                            <input type="hidden" name="priority" id="priority-input" value="<?= htmlspecialchars($priority); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="To do" <?= ($task->getStatus() === 'To do') ? 'selected' : '' ?>>To do</option>
                            <option value="In progress" <?= ($task->getStatus() === 'In progress') ? 'selected' : '' ?>>In progress</option>
                            <option value="Done" <?= ($task->getStatus() === 'Done') ? 'selected' : '' ?>>Done</option>
                        </select>
                    </div>
                    <div class="buttons">
                        <button type="button" class="cancel-btn" onclick="window.location.href='/taskDetails?id=<?= $task->getId(); ?>'">Cancel</button>
                        <button type="submit" class="save">Save Changes</button>
                        <?php if (isset($userRole) && $userRole === 'Owner'): ?>
                        <button type="button" class="delete" onclick="confirmDelete(<?= $task->getId(); ?>)">Delete</button>
                        <?php endif; ?>
                    </div>
                </form>
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

        function selectPriority(priority) {
            document.querySelectorAll('.priority-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            const selectedBtn = document.querySelector(`[data-priority="${priority}"]`);
            if (selectedBtn) {
                selectedBtn.classList.add('active');
            }
          
            document.getElementById('priority-input').value = priority;
        }

        function confirmDelete(taskId) {
            if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/deleteTask';
                
                const taskIdInput = document.createElement('input');
                taskIdInput.type = 'hidden';
                taskIdInput.name = 'task_id';
                taskIdInput.value = taskId;
                
                form.appendChild(taskIdInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('task-desc');
            if (textarea) {
                autoResize(textarea);
            }

            // Set initial priority button state
            const currentPriority = document.getElementById('priority-input').value;
            selectPriority(currentPriority);

            document.querySelectorAll('.priority-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    selectPriority(this.dataset.priority);
                });
            });
        });
    </script>
</body>

</html>
