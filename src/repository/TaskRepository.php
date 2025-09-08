<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Task.php';

class TaskRepository extends Repository {

    public function addTask(Task $task) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tasks (title, description, deadline, priority, id_assigned_by, status)
            VALUES (:title, :description, :deadline, :priority, :created_by, :status)
        ');

        $title = $task->getTitle();
        $description = $task->getDescription();
        $deadline = $task->getDeadline();
        $priority = $task->getPriority();
        $status = 'To do';  //default status

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':status', $status);

        $stmt->execute();
    }

    public function getTask($id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tasks WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($task === false) {
            return null;
        }

        return new Task(
            $task['title'],
            $task['description'],
            $task['deadline'],
            $task['priority'],
            $task['id_assigned_by'],
            $task['status']
        );
    }

    public function getTasks() {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tasks ORDER BY created_at DESC
        ');
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as $task) {
            $result[] = new Task(
                $task['title'],
                $task['description'],
                $task['deadline'],
                $task['priority'],
                $task['id_assigned_by'],
                $task['status']
            );
        }

        return $result;
    }
}
