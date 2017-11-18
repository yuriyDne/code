<?php

namespace mvc\Dto;

class DataProvider
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var int
     */
    private $currentPage;
    /**
     * @var int
     */
    private $totalPages;

    /**
     * DataProvider constructor.
     * @param array $data
     * @param int $currentPage
     * @param int $totalPages
     */
    public function __construct(
        array $data,
        $currentPage,
        $totalPages
    ) {
        $this->data = $data;
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param int $page
     * @return bool
     */
    public function isCurrentPage(int $page)
    {
        return $this->currentPage === $page;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function getPages()
    {
        return range(1, $this->getTotalPages());
    }
}