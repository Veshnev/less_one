<?php

declare(strict_types = 1);

namespace components;

use DirectoryIterator;

class ConfigAggregatorComponent
{
    /** @var array Массив конфигов */
    private $configs = [];

    /**
     * ConfigAggregatorComponent constructor.
     * @param string $configFolderPath
     */
    public function __construct(string $configFolderPath)
    {
        $this->processAllConfigs($configFolderPath);
    }

    /**
     * Перебирает и читает все конфиги
     * @param string $path
     */
    private function processAllConfigs(string $path): void
    {
        $dir = new DirectoryIterator($path);

        foreach ($dir as $fileInfo) {
            $path = $fileInfo->getPath() . DIRECTORY_SEPARATOR . $fileInfo->getFilename();

            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                $this->processAllConfigs($path);
            } else if ($fileInfo->isFile()) {
                $newConfig = $this->readConfigFile($path);

                if (is_array($newConfig)) {
                    $this->addConfig($newConfig);
                }
            }
        }
    }

    /**
     * Читает файл конфига
     *
     * @param $filePath
     * @return mixed
     */
    private function readConfigFile($filePath)
    {
        return include $filePath;
    }

    /**
     * Добавляет новый конфиг в копилку кнфигов
     *
     * @param array $newConfig
     */
    private function addConfig(array $newConfig): void
    {
        // TODO Нужен перебор подключей для соединения с вложенными конфигами, иначе тупо перезапись
//        foreach ($newConfig as & $item) {
//            if (is_array($item)) {
//                $item = $this->addConfig($item);
//            }
//        }

        $this->configs = array_merge($newConfig, $this->configs);
    }

    public function getConfig($name)
    {
        if (!isset($this->configs[$name])) {
            throw new \Exception('Required config not defined');
        }

        return $this->configs[$name];
    }

    /**
     * Возвращает массив конфигов
     *
     * @return array
     */
    public function getAllConfigs() :array
    {
        return $this->configs;
    }
}