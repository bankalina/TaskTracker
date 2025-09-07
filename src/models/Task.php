<?php

class Task {
    private $title;
    private $description;
    private $deadline;
    private $priority;
    private $createdBy;

    public function __construct($title, $description, $deadline, $priority, $createdBy) {
        $this->title = $title;
        $this->description = $description;
        $this->deadline = $deadline;
        $this->priority = $priority;
        $this->createdBy = $createdBy;
    }

    public function getTitle() {
        return $this->title;

    }
    public function getDescription() {
        return $this->description;
    }

    public function getDeadline() {
        return $this->deadline;
    }

    public function getPriority() {
        return $this->priority;
    }

    public function getCreatedBy() {
        return $this->createdBy;
    }
}
