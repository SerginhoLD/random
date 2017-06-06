<?php
namespace SerginhoLD\Random;

/**
 * Class Random
 * @package SerginhoLD\Random
 */
class Random
{
    /** @var array */
    private $storage = [];
    
    /**
     * @param mixed $item Что угодно
     * @param int|float $weight Вес
     * @return $this
     * @throws \Exception
     */
    public function add($item, $weight = 1)
    {
        $weight = (float)$weight;
        
        if ($weight <= 0)
            throw new \Exception('Weight is not a positive number');
        
        $this->storage[] = [
            'item' => $item,
            'weight' => $weight,
        ];
        
        return $this;
    }
    
    /**
     * @param array $storage
     * @return array
     * @throws \Exception
     */
    private function getRandomItemWithKey(array $storage)
    {
        if (empty($storage))
            throw new \Exception('Array of elements is empty');
        
        $totalWeight = array_sum(array_column($storage, 'weight'));
        $rand = mt_rand(1, 100);
        $percent = 0;
        $key = null;
        
        foreach ($storage as $i => $item)
        {
            $percent += 100 / $totalWeight * $item['weight'];
            
            if ($rand <= $percent)
            {
                $key = $i;
                break;
            }
        }
        
        if ($key === null)
        {
            //throw new \Exception('Something went wrong');
            end($storage);
            $key = key($storage);
        }
        
        return [
            'item' => $storage[$key]['item'],
            'key' => $key,
        ];
    }
    
    /**
     * @return mixed
     * @throws \Exception
     */
    public function getRandomItem()
    {
        $arItem = $this->getRandomItemWithKey($this->storage);
        return $arItem['item'];
    }
    
    /**
     * @param int $count
     * @return mixed[]
     * @throws \Exception
     */
    public function getRandomList($count = 2)
    {
        $count = (int)$count;
        
        if ($count < 1)
            throw new \Exception('Count is not a positive integer');
        
        $storage = $this->storage;
        $list = [];
        
        for ($j = 0; $j < $count; $j++)
        {
            $arItem = $this->getRandomItemWithKey($storage);
            $list[] = $arItem['item'];
            unset($storage[$arItem['key']]);
        }
        
        return $list;
    }
}