<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Task.php';
require_once __DIR__.'/../repository/TaskRepository.php';

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
        // Check if user is logged in
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return $this->render('login', ['messages' => ['Please log in to view task details.']]);
        }

        // Get task ID from URL parameter
        $taskId = $_GET['id'] ?? null;
        if (!$taskId) {
            return $this->render('tasks', ['messages' => ['Task ID is required.']]);
        }

        // Get task details
        $task = $this->taskRepository->getTask($taskId);
        if (!$task) {
            return $this->render('tasks', ['messages' => ['Task not found.']]);
        }

        // Get subtasks for this task
        $subtasks = $this->taskRepository->getSubtasks($taskId);

        $this->render('taskDetails', ['task' => $task, 'subtasks' => $subtasks]);
    }

    public function addTask() {
        // Check if user is logged in (for both GET and POST)
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

        // Get task ID from URL parameter
        $taskId = $_GET['id'] ?? null;
        if (!$taskId) {
            return $this->render('tasks', ['messages' => ['Task ID is required.']]);
        }

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
            
            // Get task_id from POST instead of GET
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
}
