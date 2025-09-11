<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Task.php';
require_once __DIR__.'/../repository/TaskRepository.php';
require_once __DIR__.'/../utils/PermissionChecker.php';

class TaskController extends AppController {

    private $taskRepository;

    public function __construct() {
        parent::__construct();
        $this->taskRepository = new TaskRepository();
    }

    public function tasks() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login', ['messages' => ['Please log in to view tasks.']]);
        }

        $tasks = $this->taskRepository->getUserTasks($_SESSION['user_id']);
        $this->render('tasks', ['tasks' => $tasks]);
    }

    public function taskDetails() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login', ['messages' => ['Please log in to view task details.']]);
        }

        $taskId = $_GET['id'] ?? null;
        if (!$taskId) {
            return $this->render('tasks', ['messages' => ['Task ID is required.']]);
        }

        PermissionChecker::requirePermission('view_task', $_SESSION['user_id'], $taskId);

        $task = $this->taskRepository->getTask($taskId);
        if (!$task) {
            return $this->render('tasks', ['messages' => ['Task not found.']]);
        }

        $subtasks = $this->taskRepository->getSubtasks($taskId);
        
        // Get user permissions for this task
        $permissions = PermissionChecker::getUserPermissions($_SESSION['user_id'], $taskId);

        $this->render('taskDetails', [
            'task' => $task, 
            'subtasks' => $subtasks,
            'userRole' => $permissions['role'],
            'canEdit' => $permissions['canEdit'],
            'canDelete' => $permissions['canDelete']
        ]);
    }

    public function addTask() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login', ['messages' => ['Please log in to add tasks.']]);
        }

        if ($this->isPost()) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $deadline = $_POST['deadline'];
            $priority = $_POST['priority'];

            // Validate input
            if (empty($title) || empty($description) || empty($deadline) || empty($priority)) {
                return $this->render('addTask', ['messages' => ['All fields are required!']]);
            }

            // Validate priority against ENUM values
            if (!TaskRepository::isValidPriority($priority)) {
                return $this->render('addTask', ['messages' => ['Invalid priority value!']]);
            }

            $task = new Task(null, $title, $description, $deadline, $priority, $_SESSION['user_id'], 'To do');
            $this->taskRepository->addTask($task);

            $tasks = $this->taskRepository->getUserTasks($_SESSION['user_id']);
            return $this->render("tasks", ['tasks' => $tasks]);
        }

        return $this->render('addTask');
    }

    public function editTask() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login', ['messages' => ['Please log in to edit tasks.']]);
        }

        $taskId = $_GET['id'] ?? null;
        if (!$taskId) {
            return $this->render('tasks', ['messages' => ['Task ID is required.']]);
        }

        PermissionChecker::requirePermission('edit_task', $_SESSION['user_id'], $taskId);

        $task = $this->taskRepository->getTask($taskId);
        if (!$task) {
            return $this->render('tasks', ['messages' => ['Task not found.']]);
        }

        if ($this->isPost()) {
            
            $title = $_POST['title'];
            $description = $_POST['description'];
            $deadline = $_POST['deadline'];
            $priority = $_POST['priority'];
            $status = $_POST['status'];
            
            $taskId = $_POST['task_id'] ?? $taskId;

            if (empty($title) || empty($description) || empty($deadline) || empty($priority) || empty($status)) {
                return $this->render('editTask', ['task' => $task, 'messages' => ['All fields are required!']]);
            }

            // Validate priority and status against ENUM values
            if (!TaskRepository::isValidPriority($priority)) {
                return $this->render('editTask', ['task' => $task, 'messages' => ['Invalid priority value!']]);
            }

            if (!TaskRepository::isValidStatus($status)) {
                return $this->render('editTask', ['task' => $task, 'messages' => ['Invalid status value!']]);
            }

            $this->taskRepository->updateTask($taskId, $title, $description, $deadline, $priority, $status);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/taskDetails?id={$taskId}");
            exit();
        }

        return $this->render('editTask', ['task' => $task]);
    }

    public function deleteTask() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login', ['messages' => ['Please log in to delete tasks.']]);
        }

        if (!$this->isPost()) {
            header('Location: /tasks');
            exit();
        }

        $taskId = $_POST['task_id'] ?? null;
        if (!$taskId) {
            return $this->render('tasks', ['messages' => ['Task ID is required.']]);
        }

        PermissionChecker::requirePermission('delete_task', $_SESSION['user_id'], $taskId);

        $result = $this->taskRepository->deleteTask($taskId);
        
        if ($result) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/tasks?message=Task deleted successfully");
            exit();
        } else {
            return $this->render('tasks', ['messages' => ['Failed to delete task.']]);
        }
    }
}
