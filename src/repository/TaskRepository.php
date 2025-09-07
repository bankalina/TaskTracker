<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Task.php';

class TaskRepository extends Repository {

    public function addTask(Task $task) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tasks (title, description, deadline, priority, id_assigned_by, status, created_at, updated_at)
            VALUES (:title, :description, :deadline, :priority, :created_by, :status, NOW(), NOW())
        ');

        $title = $task->getTitle();
        $description = $task->getDescription();
        $deadline = $task->getDeadline();
        $priority = $task->getPriority();
        $createdBy = $task->getCreatedBy();
        $status = 'To do';  //default status

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':created_by', $createdBy);
        $stmt->bindParam(':status', $status);

        $stmt->execute();
    }
}
