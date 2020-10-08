<?php

namespace MediaMars\Restaurant\Rule\Service;

use MediaMars\Restaurant\Data\ClientsGroup;
use MediaMars\Restaurant\DataStructure\ClientGroupQueueInterface;

class ClientsGroupQueueService
{
    /**
     * @param ClientGroupQueueInterface $groupQueue
     * @param ClientsGroup $afterGroup
     * @return ClientsGroup|null
     */
    public function getLessSizeGroupAfterGroup(ClientGroupQueueInterface $groupQueue, ClientsGroup $afterGroup)
    {
        if ($groupQueue->contains($afterGroup)) {
            $startSearch = false;
            foreach ($groupQueue as $group) {
                if ($group === $afterGroup) {
                    $startSearch = true;
                    continue;
                }
                /** @var ClientsGroup $group */
                if ($startSearch && $group->size() < $afterGroup->size()) {
                    return $group;
                }
            }
        }
    }
}