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
        $tasks = $this->taskRepository->getTasks();
        $this->render('tasks', ['tasks' => $tasks]);
    }

    public function taskDetails() {
        $this->render('taskDetails');
    }

    public function addTask() {
        if ($this->isPost()) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $deadline = $_POST['deadline'];
            $priority = $_POST['priority'];

            // TODO: get id of the currently logged user
            $createdBy = 1;

            $task = new Task($title, $description, $deadline, $priority, $createdBy);
            $this->taskRepository->addTask($task);

            return $this->render('tasks', ['messages' => ['Task added successfully!']]);
        }

        return $this->render('addTask');
    }
}
