<?php

declare(strict_types = 1);

namespace fanymagnet;

class Event
{
    /**
     * @var array Список событий
     */
    private static $list = [];

    /**
     * Добавить событие
     *
     * @param string   $name     Наименование события
     * @param callable $function Обработчик события
     */
    public static function on(string $name, callable $function): void
    {
        static::$list[$name][] = $function;
    }

    /**
     * Удалить событие
     *
     * @param string $name Наименование события
     */
    public static function off(string $name): void
    {
        if (static::exists($name) === false) {
            throw new RuntimeException("Событие «{$name}» не найдено!");
        }

        unset(static::$list[$name]);
    }

    /**
     * Вызвать событие
     *
     * @param string $name    Наименование события
     * @param mixed  ...$args Аргументы обработчика
     * @return array          Результаты вызова обработчиков
     */
    public static function trigger(string $name, ...$args): array
    {
        if (static::exists($name) === false) {
            throw new RuntimeException("Событие «{$name}» не найдено!");
        }

        $callback = static function (callable $function) use ($args) {
            return $function(...$args);
        };

        return array_map($callback, static::$list[$name]);
    }

    /**
     * Существует ли событие
     *
     * @param string $name Наименование события
     * @return bool
     */
    public static function exists(string $name): bool
    {
        return array_key_exists($name, static::$list);
    }
}
