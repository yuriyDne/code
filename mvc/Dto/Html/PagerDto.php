<?php

namespace mvc\Dto\Html;

use mvc\Dto\DataProvider;

/**
 * Class PagerDto
 * @package mvc\Dto\Html
 */
class PagerDto
{
    /**
     * @var DataProvider
     */
    private $dataProvider;
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $pagerParamSeparator;

    /**
     * PagerDto constructor.
     * @param DataProvider $dataProvider
     * @param string $baseUrl
     */
    public function __construct(
        DataProvider $dataProvider,
        string $baseUrl
    ) {
        $this->pagerParamSeparator = (strpos($baseUrl, '?') === false) ? '?' : '&';
        $this->dataProvider = $dataProvider;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return DataProvider
     */
    public function getDataProvider(): DataProvider
    {
        return $this->dataProvider;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getPagerParamSeparator(): string
    {
        return $this->pagerParamSeparator;
    }
}