<?php

namespace Service;

use config\Constants;
use lib\DirectoryHelper;
use lib\Exception\FileNotFoundException;
use mvc\Enum\AssetType;

class ClientScript
{
    const CACHE_DURATION = 24 * 60 * 60;
    const PUBLIC_ASSETS_PATH = SITE_ROOT.'assets'.DS;

    const PUBLIC_ASSETS_WEB_PATH = '/assets/';

    const ASSET_PATHS = [
        AssetType::CORE =>  MVC_PATH. 'assets'. DS,
        AssetType::ADMIN => MVC_PATH. 'Module'.DS.'Admin'.DS.'assets'. DS,
    ];

    const DEBUG_ASSET_WEB_PATH = [
        AssetType::CORE =>   '/mvc/assets/',
        AssetType::ADMIN => '/mvc/Module/Admin/assets/'
    ];


    /**
     * @var DirectoryHelper
     */
    private $directoryHelper;

    /**
     * @var string
     */
    private $currentVersion;

    /**
     * @var array
     */
    private $jsAssetMap = [];

    /**
     * @var array
     */
    private $cssAssetMap = [];

    /**
     * @var AssetType|null
     */
    private $defaultAssetType = null;
    /**
     * @var bool
     */
    private $isProductionMode;

    /**
     * @var array
     */
    private $externalJsScripts = [];

    /**
     * @var array
     */
    private $externalCssScripts = [];

    /**
     * ClientScript constructor.
     * @param DirectoryHelper $directoryHelper
     * @param bool $isProductionMode
     */
    public function __construct(
        DirectoryHelper $directoryHelper,
        bool $isProductionMode
    ) {
        $this->directoryHelper = $directoryHelper;
        $this->defaultAssetType = AssetType::CORE();
        $this->isProductionMode = $isProductionMode;

        if ($this->isProductionMode) {
            $this->setUpCurrentVersion();
            $this->publishResourcesIfExpired();
        }
    }

    /**
     * @return array
     */
    public function getJsScripts()
    {
        return $this->mergeScripts($this->jsAssetMap, $this->externalJsScripts);
    }

    /**
     * @return array
     */
    public function getCssScripts()
    {
        return $this->mergeScripts($this->cssAssetMap, $this->externalCssScripts);
    }

    /**
     * @param array $assetMaps
     * @param array $externalScripts
     * @return array
     */
    private function mergeScripts(array $assetMaps, array $externalScripts)
    {
        $assetMapAll = [];
        foreach ($assetMaps as $scripts) {
            $assetMapAll = array_merge($assetMapAll, $scripts);
        }

        return array_merge(
            array_values($externalScripts),
            array_values($assetMapAll)
        );
    }

    /**
     * @param string $relativePath
     * @param AssetType|null $assetType
     */
    public function registerCssFile(
        string $relativePath,
        AssetType $assetType = null
    ) {
        $relativePath = "css/{$relativePath}.css";
        $this->cssAssetMap = $this->registerFile($relativePath, $this->cssAssetMap, $assetType);
    }

    /**
     * @param string $relativePath
     * @param AssetType|null $assetType
     */
    public function registerJsFile(
        string $relativePath,
        AssetType $assetType = null
    ) {
        $relativePath = "js/{$relativePath}.js";
        $this->jsAssetMap = $this->registerFile($relativePath, $this->jsAssetMap, $assetType);
    }

    /**
     * @param AssetType $assetType
     * @param string $relativeUrl
     * @return string
     */
    public function getPublicUrl(AssetType $assetType, string $relativeUrl = '')
    {
        if (!$this->isProductionMode) {
            $result = self::DEBUG_ASSET_WEB_PATH[$assetType->getValue()]. $relativeUrl;
        } else {
            $result = self::PUBLIC_ASSETS_WEB_PATH.'/'.$this->currentVersion.'/'.$assetType.'/'. $relativeUrl;
        }

        return $result;
    }

    /**
     * @param string $relativePath
     * @param array $assetMap
     * @param AssetType|null $assetType
     * @return array
     */
    private function registerFile(
        string $relativePath,
        array $assetMap,
        AssetType $assetType = null
    ) {
        if (is_null($assetType)) {
            $assetType = $this->defaultAssetType;
        }

        $this->assertFileExists($assetType, $relativePath);

        if (!isset($assetMap[$assetType->getValue()])) {
            $assetMap[$assetType->getValue()] = [];
        }
        if (!isset($assetMap[$assetType->getValue()][$relativePath])) {
            $assetMap[$assetType->getValue()][$relativePath] = $this->getPublicUrl($assetType, $relativePath);
        }

        return $assetMap;
    }

    private function publishResourcesIfExpired()
    {
        $currentTimestamp = time();

        if (Constants::DEBUG_MODE
            || $currentTimestamp - $this->currentVersion > self::CACHE_DURATION
        ) {
            $this->currentVersion = $currentTimestamp;
            $this->cleanAssets();
            $this->createNewBuild($currentTimestamp);
        }
    }

    private function setUpCurrentVersion()
    {
        $result = 0;
        $versions = $this->directoryHelper->getList(self::PUBLIC_ASSETS_PATH);
        foreach ($versions as $version) {
            if ($version > $result) {
                $result = $version;
            }
        }

        $this->currentVersion = (int) $result;
    }

    private function cleanAssets()
    {
        $this->directoryHelper->deleteRecursive(self::PUBLIC_ASSETS_PATH);
        $this->directoryHelper->makeDirectory(self::PUBLIC_ASSETS_PATH);
    }

    /**
     * @param AssetType $assetType
     * @param string $relativeFile
     */
    private function assertFileExists(AssetType $assetType, string $relativeFile)
    {
        if (!array_key_exists($assetType->getValue(), self::ASSET_PATHS)) {
            throw new \LogicException(
                __METHOD__.': No asset path specify for asset: '.$assetType->getValue()
            );
        }

        if (!$this->isProductionMode && !array_key_exists($assetType->getValue(), self::DEBUG_ASSET_WEB_PATH)) {
            throw new \LogicException(
                __METHOD__.': No debug web path specified for asset: '.$assetType->getValue()
            );
        }

        $internalFilePath = self::ASSET_PATHS[$assetType->getValue()].$relativeFile;
        if (!is_file($internalFilePath)) {
            throw new FileNotFoundException($internalFilePath);
        }

        if ($this->isProductionMode) {
            $publicFilePath = self::PUBLIC_ASSETS_PATH.$assetType->getValue().DS.$relativeFile;
            if (!is_file($publicFilePath)) {
                throw new FileNotFoundException($publicFilePath);
            }
        }
    }

    /**
     * @param int $version
     */
    private function createNewBuild(int $version)
    {
        $this->directoryHelper->makeDirectory(self::PUBLIC_ASSETS_PATH. $version);
        $publicAssetPath = self::PUBLIC_ASSETS_PATH.$this->currentVersion.DS;
        foreach (self::ASSET_PATHS as $type => $sourceSrc) {
            if (!is_dir($publicAssetPath.$type)) {
                $this->directoryHelper->makeDirectory($publicAssetPath.$type);
            }
            $this->directoryHelper->copyRecursive($sourceSrc, $publicAssetPath.$type);
        }

    }

    /**
     * @param AssetType $defaultAssetType
     */
    public function setDefaultAssetType(AssetType $defaultAssetType)
    {
        $this->defaultAssetType = $defaultAssetType;
    }

    /**
     * @param string $url
     */
    public function addExternalJsScript(string $url)
    {
        if (!isset($this->externalJsScripts[$url])) {
            $this->externalJsScripts[$url] = $url;
        }
    }

    /**
     * @param string $url
     */
    public function addExternalCssScript(string $url)
    {
        if (!isset($this->externalCssScripts[$url])) {
            $this->externalCssScripts[$url] = $url;
        }
    }

}