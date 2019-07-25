**Пример использоватния**:

```
Event::on('Event1', static function (int $i) {
   echo $i . PHP_EOL;
   Event::trigger('Event2', $i + 1);

});

Event::on('Event2', static function (int $i) {
    echo $i . PHP_EOL;
});

Event::trigger('Event1', 1);
```

**Результат использоватния**:

```
1
2
```
