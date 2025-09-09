<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Task.php';

class TaskRepository extends Repository {
    
    // ENUM values for database
    const ROLE_OWNER = 'Owner';
    const ROLE_VIEWER = 'Viewer';
    const ROLE_ASSIGNED = 'Assigned';
    
    const PRIORITY_HIGH = 'High';
    const PRIORITY_MEDIUM = 'Medium';
    const PRIORITY_LOW = 'Low';
    
    const STATUS_TODO = 'To do';
    const STATUS_IN_PROGRESS = 'In progress';
    const STATUS_DONE = 'Done';

    public function addTask(Task $task) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tasks (title, description, deadline, priority, id_assigned_by, status)
            VALUES (:title, :description, :deadline, :priority, :created_by, :status)
        ');

        $title = $task->getTitle();
        $description = $task->getDescription();
        $deadline = $task->getDeadline();
        $priority = $task->getPriority();
        $created_by = $task->getCreatedBy();
        $status = $task->getStatus();

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':status', $status);

        $stmt->execute();
        
        // Trigger in database automatically adds entry to user_tasks table
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
            $task['id'],
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
                $task['id'],
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

    public function getUserTasks($userId) {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT t.* FROM tasks t
            INNER JOIN user_tasks ut ON t.id = ut.id_task
            WHERE ut.id_user = :user_id
            ORDER BY t.created_at DESC
        ');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as $task) {
            $result[] = new Task(
                $task['id'],
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

    public function assignUserToTask($userId, $taskId, $role = self::ROLE_ASSIGNED) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO user_tasks (id_user, id_task, role)
            VALUES (:user_id, :task_id, :role)
            ON CONFLICT (id_user, id_task) DO UPDATE SET role = :role
        ');
        
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role);
        
        $stmt->execute();
    }

    public function removeUserFromTask($userId, $taskId) {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM user_tasks 
            WHERE id_user = :user_id AND id_task = :task_id
        ');
        
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        
        $stmt->execute();
    }

    public function getTaskUsers($taskId) {
        $stmt = $this->database->connect()->prepare('
            SELECT u.id, u.username, u.email, ut.role
            FROM users u
            INNER JOIN user_tasks ut ON u.id = ut.id_user
            WHERE ut.id_task = :task_id
        ');
        
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Validation methods for ENUM values
    public static function isValidRole($role) {
        return in_array($role, [self::ROLE_OWNER, self::ROLE_VIEWER, self::ROLE_ASSIGNED]);
    }

    public static function isValidPriority($priority) {
        return in_array($priority, [self::PRIORITY_HIGH, self::PRIORITY_MEDIUM, self::PRIORITY_LOW]);
    }

    public static function isValidStatus($status) {
        return in_array($status, [self::STATUS_TODO, self::STATUS_IN_PROGRESS, self::STATUS_DONE]);
    }

    // Get all available ENUM values
    public static function getAvailableRoles() {
        return [self::ROLE_OWNER, self::ROLE_VIEWER, self::ROLE_ASSIGNED];
    }

    public static function getAvailablePriorities() {
        return [self::PRIORITY_HIGH, self::PRIORITY_MEDIUM, self::PRIORITY_LOW];
    }

    public static function getAvailableStatuses() {
        return [self::STATUS_TODO, self::STATUS_IN_PROGRESS, self::STATUS_DONE];
    }
}
