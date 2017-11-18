<?php

namespace mvc\Repository;

use mvc\Dto\DataProvider;
use mvc\Dto\SortOrder;
use mvc\Dto\TaskDto;
use mvc\Enum\Repository\TaskField;
use mvc\Enum\TaskStatus;
use mvc\Exception\NoEntityFoundException;
use mvc\Exception\WrongEntityException;

class TaskRepository extends AbstractRepository
{
    protected $tableName = 'task';

    /**
     * @param TaskDto $task
     */
    public function save(TaskDto $task)
    {
        if ($task->getId()) {
            $this->doUpdate(
                $task->getId(),
                $this->dtoToArray($task)
            );
        } else {
            $this->doInsert($this->dtoToArray($task));
        }
    }

    /**
     * @param int $id
     * @return TaskDto
     */
    public function getById(int $id)
    {
        $result = null;

        $rawData = $this->doGetById($id);
        if (empty($rawData)) {
            throw new NoEntityFoundException(__CLASS__.':'.$id);
        }

        return $this->arrayToDto($rawData);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param SortOrder|null $sortOrder
     * @return DataProvider
     */
    public function getDataProvider(
        int $page,
        int $perPage,
        SortOrder $sortOrder = null
    ) {
        $order = 'id desk';
        if (!is_null($sortOrder)) {
            if (!$sortOrder->getFieldName() instanceof TaskField) {
                throw new WrongEntityException(
                    'sortOrder->getFieldName()',
                    TaskField::class,
                    get_class($sortOrder->getFieldName())
                );
            }
            $order = $sortOrder->getFieldName()->getValue().' '.$sortOrder->getSortDirection()->getValue();
        }
        $itemsCount = $this->doCount();
        $offset = $perPage * ($page - 1);
        $totalPages = $itemsCount / $perPage;
        if ($itemsCount % $perPage) {
            $totalPages ++;
        }

        $rawData = $this->doFindAll([], $order, $offset, $perPage);

        $data = [];

        if (!empty($rawData)) {
            foreach ($rawData as $item) {
                $data[] = $this->arrayToDto($item);
            }
        }

        return new DataProvider(
            $data,
            $page,
            $totalPages
        );
    }



    /**
     * @param array $rawData
     * @return TaskDto
     */
    private function arrayToDto(array $rawData)
    {
        return new TaskDto(
            (int) $rawData['id'],
            $rawData['userName'],
            $rawData['email'],
            $rawData['description'],
            new TaskStatus((int)$rawData['status']),
            $rawData['image']
        );
    }

    /**
     * @param TaskDto $task
     * @return array
     */
    private function dtoToArray(TaskDto $task)
    {
        return [
            'userName' => $task->getUserName(),
            'email' => $task->getEmail(),
            'description' => $task->getDescription(),
            'image' => $task->getImage(),
            'status' => $task->getStatus()->getValue(),
        ];
    }

}