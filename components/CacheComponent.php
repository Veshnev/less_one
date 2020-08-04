<?php

declare(strict_types = 1);

namespace components;

class CacheComponent
{
    /** @var string Папка кэширования */
    protected static $cachePath = null;

    /** @var array Кэш всемогущий */
    protected static $cache = null;

    /**
     * Назначает дурректорию для чтения файлов кэша
     *
     * @param string $cachePath
     */
    public static function setRootDir(string $cachePath)
    {
        static::$cachePath = $cachePath;
    }

    /**
     * Возвращает кэш по имени класса
     *
     * @param string $className
     * @return array
     */
    public static function getCache(string $className): array
    {
        if (!isset(static::$cache[$className])) {
            static::$cache[$className] = static::readCacheFromFile(static::getFilePath($className));
        }

        return static::$cache[$className];
    }

    /**
     * Назначает кэш по имени класса
     *
     * @param string $className
     * @param array $config
     */
    public static function setCache(string $className, array $config): void
    {
        static::$cache[$className] = $config;
        static::recordCache($className, $config);
    }

    /**
     * Записывает кэш в файл
     *
     * @param string $className
     * @param array $config
     */
    protected static function recordCache(string $className, array $config): void
    {
        static::checkPath($className);
        $filePath = static::getFilePath($className);
        file_put_contents($filePath, serialize($config));
    }

    /**
     * Проверяет: существует ли папка для записи кэша. Если нет, то создаёт её.
     *
     * @param string $className
     */
    protected static function checkPath(string $className): void
    {
        $folder = static::getFilePath($className, false);

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    /**
     * Возвращает весь кэш
     *
     * @return array
     */
    public static function getAllCache(): array
    {
        return static::$cache ?? [];
    }

    /**
     * Очищает весь кэш
     *
     * @return bool
     */
    public static function clearCache(): bool
    {
        // @TODO удалить всё, что находится в корневый папке static::$cacheDir

        return true;
    }

    /**
     * Возвращает полный путь к файлу кэша
     *
     * @param string $className
     * @param bool $withFileName
     * @return string
     */
    protected static function getFilePath(string $className, $withFileName = true): string
    {
        $nameArray = explode('\\', $className);
        $fileName = array_pop($nameArray);

        $path = static::$cachePath
            . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, $nameArray);

        if ($withFileName === true) {
            return $path . DIRECTORY_SEPARATOR . $fileName .  '.cache';
        }

        return $path;
    }

    /**
     * @param string $filePath
     * @return array
     */
    protected static function readCacheFromFile(string $filePath): array
    {
        $result = [];

        try {
            $data = file_get_contents($filePath);
            $result = unserialize($data);
        } finally {
            return $result;
        }
    }
}
