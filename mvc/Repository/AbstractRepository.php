<?php

namespace mvc\Repository;

abstract class AbstractRepository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * AbstractRepository constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        if (empty($this->tableName)) {
            throw new \LogicException('Table name isn\'t specify for '.get_class($this));
        }
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    protected function doGetById(int $id)
    {
        $command = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = :id LIMIT 1");
        $command->bindParam(':id', $id, \PDO::PARAM_INT);
        if ($command->execute()) {
            $row = $command->fetch(\PDO::FETCH_ASSOC);
        } else {
            $row = [];
        }

        return $row;
    }

    /**
     * @param array $fields
     * @return int
     */
    protected function doInsert(array $fields)
    {
        $keySql = '`'. implode('`,`', array_keys($fields)).'`';
        $valuesSql = implode(',', $this->getQuotedValues($fields));

        $sql = "INSERT INTO {$this->tableName} ($keySql) VALUES ($valuesSql)";
        $this->pdo->prepare($sql)->execute();

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param array $fields
     * @param string $pkName
     * @return bool
     */
    protected function doUpdate(int $id, array $fields, string $pkName = 'id')
    {
        if (empty($fields)) {
            return false;
        }
        $updatedFieldsSql = $this->getParamsSql($fields, ' , ');
        $sql = "UPDATE {$this->tableName} SET $updatedFieldsSql WHERE {$pkName} = $id";
        $this->pdo->prepare($sql)->execute();
    }

    /**
     * @param array $attributes
     * @param string|null $order
     * @param int|null $offset
     * @param int|null $limit
     * @return array
     */
    protected function doFindAll(
        array $attributes = [],
        string $order = null,
        int $offset = null,
        int $limit = null
    ) {
        $paramsSql = !empty($attributes)
            ? $this->getParamsSql($attributes, ' AND ')
            : '1=1';
        $sql = "SELECT * FROM {$this->tableName} WHERE $paramsSql";
        if ($order) {
            $sql.= ' ORDER BY '.$order;
        }
        if (!is_null($offset)
            && !is_null($limit)
        ) {
            $sql.= " LIMIT $offset, $limit";
        }

        $command = $this->pdo->prepare($sql);
        $command->execute();
        return $command->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    protected function doCount(array $attributes = [])
    {
        $paramsSql = !empty($attributes)
            ? $this->getParamsSql($attributes, ' AND ')
            : '1=1';
        $sql = "SELECT count(*) FROM {$this->tableName} WHERE  $paramsSql";
        $command = $this->pdo->prepare($sql);
        $command->execute();
        return $command->fetchColumn();
    }

    /**
     * @param array $fields
     * @param string $separator
     * @return string
     */
    private function getParamsSql(array $fields, string $separator)
    {
        $result = [];
        foreach ($fields as $key => $value) {
            $result[] = "`$key` = ".$this->getQuotedValue($value);
        }

        return implode($separator, $result);
    }

    /**
     * @param array $values
     * @return array
     */
    private function getQuotedValues(array $values)
    {
        $result = [];

        foreach ($values as $value) {
            $result[] = $this->getQuotedValue($value);
        }

        return $result;
    }

    /**
     * @param $value
     * @return string
     */
    private function getQuotedValue($value)
    {
        if (is_numeric($value)) {
            return $value;
        } else {
            return $this->pdo->quote($value);
        }
    }
}