# Random items by weight

```php
use SerginhoLD\Random\Random;

$oRandom = new Random();

$oRandom
    ->add('A', 4)
    ->add('B', 2)
    ->add('C', 6);

var_dump($oRandom->getRandomItem());

$count = 2;

var_dump($oRandom->getRandomList($count));
```