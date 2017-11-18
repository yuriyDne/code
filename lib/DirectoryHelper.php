<?php

namespace lib;

use lib\Exception\WrongDirectoryException;

class DirectoryHelper
{
    const NEW_DIRECTORY_PERMISSION = 0775;

    public function getList(string $path)
    {
        $this->checkDirectory($path);
        $result = [];
        $items = scandir($path);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            if (is_dir($path . DS . $item)) {
                $result[] = $item;
            }
        }

        return $result;
    }

    public function deleteRecursive(string $path)
    {
        $this->checkDirectory($path);
        $files = array_diff(
            scandir($path),
            ['.','..']
        );

        foreach ($files as $file) {
            $fullPath = $path.DS.$file;
            is_dir($fullPath)
                ? $this->deleteRecursive($fullPath)
                : unlink($fullPath);
        }
        return rmdir($path);
    }

    public function copyRecursive(string $sourcePath, string $destinationPath)
    {
        $this->checkDirectory($sourcePath);
        $this->checkDirectory($destinationPath);

        $iterator = $this->buildRecursiveIterator($sourcePath);
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                $this->makeDirectory($destinationPath . DS . $iterator->getSubPathName());
            } else {
                copy($item, $destinationPath . DS . $iterator->getSubPathName());
            }
        }
    }

    /**
     * @param string $sourcePath
     * @return \RecursiveIteratorIterator
     */
    private function buildRecursiveIterator(string $sourcePath)
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $sourcePath,
                \RecursiveDirectoryIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );

    }

    public function makeDirectory($path)
    {
        mkdir($path, self::NEW_DIRECTORY_PERMISSION, true);
    }

    /**
     * @param string $path
     */
    private function checkDirectory(string $path)
    {
        if (!is_dir($path)) {
            throw new WrongDirectoryException($path);
        }
    }
}