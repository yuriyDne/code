<?php

namespace mvc\Dto;

use mvc\Enum\TaskStatus;

class TaskDto
{
    /**
     * @var null|int
     */
    private $id;
    /**
     * @var string
     */
    private $userName;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $description;
    /**
     * @var TaskStatus
     */
    private $status;
    /**
     * @var null|string
     */
    private $image;

    /**
     * TaskDto constructor.
     * @param null|int $id
     * @param string $userName
     * @param string $email
     * @param string $description
     * @param TaskStatus $status
     * @param string|null $image
     */
    public function __construct(
        int $id = null,
        string $userName,
        string $email,
        string $description,
        TaskStatus $status,
        string $image = null
    ) {
        $this->id = $id;
        $this->userName = $userName;
        $this->email = $email;
        $this->description = $description;
        $this->status = $status;
        $this->image = $image;
    }

    /**
     * @return null|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return TaskStatus
     */
    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    /**
     * @return null|string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(string $image = null)
    {
        $this->image = $image;
    }
}