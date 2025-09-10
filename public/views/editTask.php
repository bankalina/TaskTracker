<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="public/styles/styles.css">
</head>

<body class="taskDetails">
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
                                $isActive = ($p === $priority) ? '' : 'priority-disabled';
                            ?>
                            <button type="button" class="<?= strtolower($p) ?> <?= $isActive ?> priority-btn" data-priority="<?= $p ?>"><?= $p ?></button>
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
                    </div>
                </form>
            <?php else: ?>
                <div class="message error">Task not found.</div>
            <?php endif; ?>
        </div>
    </main>
    
    <script>
        // Auto-resize textarea to fit content
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        // Priority button selection
        function selectPriority(priority) {
            // Remove active class from all buttons
            document.querySelectorAll('.priority-btn').forEach(btn => {
                btn.classList.add('priority-disabled');
            });
            
            // Remove disabled class from selected button
            const selectedBtn = document.querySelector(`[data-priority="${priority}"]`);
            selectedBtn.classList.remove('priority-disabled');
            
            // Update hidden input
            document.getElementById('priority-input').value = priority;
        }

        // Apply auto-resize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('task-desc');
            if (textarea) {
                autoResize(textarea);
            }

            // Set initial priority button state
            const currentPriority = document.getElementById('priority-input').value;
            selectPriority(currentPriority);

            // Add click handlers to priority buttons
            document.querySelectorAll('.priority-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    selectPriority(this.dataset.priority);
                });
            });
        });
    </script>
</body>

</html>
