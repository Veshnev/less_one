<?php

declare(strict_types = 1);

namespace components;

use DirectoryIterator;

class ConfigAggregatorComponent
{
    /** @var array Массив конфигов */
    protected static $configs = [];

    /** @var null|string */
    protected static $configFolderPath = null;

    /**
     * Перебирает и читает все конфиги
     * @param string $path
     */
    protected function processAllConfigs(string $path): void
    {
        $dir = new DirectoryIterator($path);

        foreach ($dir as $fileInfo) {
            $path = $fileInfo->getPath() . DIRECTORY_SEPARATOR . $fileInfo->getFilename();

            if ($fileInfo->isDot()) {
                continue;
            }

            if ($fileInfo->isFile()) {
                $this->addConfig($this->readConfigFile($path));
            } else {
                $this->processAllConfigs($path);
            }
        }
    }

    /**
     * Читает файл конфига
     *
     * @param string $filePath
     * @return array
     */
    protected function readConfigFile(string $filePath): array
    {
        return include $filePath;
    }

    /**
     * Добавляет новый конфиг в копилку кнфигов
     *
     * @param array $newConfig
     */
    protected function addConfig(array $newConfig): void
    {
        static::$configs = array_replace_recursive(static::$configs, $newConfig);
    }

    /**
     * @param string $configFolderPath
     * @return ConfigAggregatorComponent
     */
    public function setConfigFolderPath(string $configFolderPath): self
    {
        self::$configFolderPath = $configFolderPath;
        return $this;
    }

    /**
     * @param string $name
     * @return array
     */
    public function getConfig(string $name): array
    {
        return $this->getAllConfigs()[$name];
    }

    /**
     * Возвращает массив конфигов
     *
     * @return array
     */
    public function getAllConfigs() :array
    {
        if (empty(static::$configs)) {
            static::$configs = CacheComponent::getCache(self::class);
        }

        if (empty(static::$configs)) {
            $this->processAllConfigs(static::$configFolderPath);
            CacheComponent::setCache(self::class, static::$configs);
        }
        
        return static::$configs;
    }
}
