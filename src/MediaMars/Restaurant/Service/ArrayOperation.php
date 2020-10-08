<?php

namespace MediaMars\Restaurant\Service;

class ArrayOperation
{
    /**
     * @param $element
     * @param array $elementList
     * @return array
     */
    public function addToEnd($element, array $elementList)
    {
        if (!$this->contains($element, $elementList))  {
            $elementList = array_merge($elementList, [$element]);
        }

        return $elementList;
    }

    /**
     * @param $element
     * @param array $elementList
     * @return array
     */
    public function addToBegin($element, array $elementList)
    {
        if (!$this->contains($element, $elementList))  {
            array_unshift($elementList, $element);

            $elementList = array_merge($elementList);
        }

        return $elementList;
    }

    /**
     * @param $element
     * @param mixed[] $elementList
     * @return mixed[]
     */
    public function remove($element, array $elementList)
    {
        $key = array_search($element, $elementList, true);

        if ($key !== false) {
            unset($elementList[$key]);
            $elementList = array_merge($elementList);
        }

        return $elementList;
    }

    /**
     * @param $element
     * @param mixed[] $elementList
     * @return bool
     */
    public function contains($element, array $elementList)
    {
        return in_array($element, $elementList, true);
    }

    /**
     * @param mixed[] $elementList
     * @return bool
     */
    public function isEmpty(array $elementList)
    {
        return count($elementList) === 0;
    }
}