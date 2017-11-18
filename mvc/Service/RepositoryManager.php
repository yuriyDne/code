<?php

namespace mvc\Service;

use config\Constants;
use mvc\Repository\TaskRepository;

class RepositoryManager
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * RepositoryManager constructor.
     */
    public function __construct()
    {
        $this->pdo = new \PDO(
            "mysql:host=" . Constants::MYSQL_HOST. ";dbname=" . Constants::MYSQL_DB_NAME. ";charset=utf8",
            Constants::MYSQL_USER,
            Constants::MYSQL_PASSWORD
        );
    }

    /**
     * @return TaskRepository
     */
    public function getTaskRepository()
    {
        if (is_null($this->taskRepository)) {
            $this->taskRepository = new TaskRepository($this->pdo);
        }

        return $this->taskRepository;
    }
}