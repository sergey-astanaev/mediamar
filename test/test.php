<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MediaMars\Restaurant\Data\ClientsGroup;
use MediaMars\Restaurant\Data\Table;
use MediaMars\Restaurant\DataStructure\TableList;
use MediaMars\Restaurant\DataStructure\TableListInterface;
use MediaMars\Restaurant\Factory\ClientsGroupRelationInterfaceFactory;
use MediaMars\Restaurant\RestManager;
use MediaMars\Restaurant\Rule\Service\ClientsGroupQueueService;
use MediaMars\Restaurant\Service\ArrayOperation;
use MediaMars\Restaurant\Factory\ClientsGroupRelationFactory;
use MediaMars\Restaurant\Rule\EmptyChairsTableRule;
use MediaMars\Restaurant\Rule\BigAndSmallClientsGroupRule;
use MediaMars\Restaurant\Rule\ShareEmptyChairsForSmallClientsGroupRule;
use MediaMars\Restaurant\Factory\ClientsGroupQueueFactory;
use MediaMars\Restaurant\Rule\RuleInterface;
use MediaMars\Restaurant\Factory\ClientGroupQueueFactoryInterface;

/**
 * @param TableListInterface $tables
 * @param ClientsGroup[] $groups
 */
function printTables(TableListInterface $tables, array $groups)
{
    foreach ($tables as $table) {
        /** @var Table $table */
        echo "\t" . 'Table size ' . $table->size() . ':' . PHP_EOL;
        $clientsGroupRelation = $table->getClientsGroupRelation();
        if ($clientsGroupRelation->isEmpty()) {
            echo "\t\t" . 'empty' . PHP_EOL;
        } else {
            foreach ($groups as $index => $group) {
                if ($clientsGroupRelation->contains($group)) {
                    echo "\t\t" . sprintf('Group index: %d, size: %d', $index, $group->size()) . PHP_EOL;
                }
            }
        }
    }
}

/**
 * @param RestManager $restManager
 * @param ClientsGroup[] $groups
 * @param TableListInterface $tables
 */
function testOnArriveGroups(RestManager $restManager, array $groups, TableListInterface $tables)
{
    echo PHP_EOL . 'Test onArrive groups:' . PHP_EOL;

    foreach ($groups as $index => $group) {
        echo sprintf('Arrived group index %d and size %d', $index, $group->size()) . PHP_EOL;
        $restManager->onArrive($group);
        printTables($tables, $groups);
    }
}

/**
 * @param RestManager $restManager
 * @param ClientsGroup[] $arrivedGroups
 * @param int[] $leavedGroupIndexes
 * @param TableListInterface $tables
 */
function testOnLeaveGroups(RestManager $restManager, array $arrivedGroups, array $leavedGroupIndexes, TableListInterface $tables)
{
    echo PHP_EOL . 'Test onLeave groups:' . PHP_EOL;

    foreach ($leavedGroupIndexes as $leavedGroupIndex) {
        /** @var ClientsGroup $group */
        $group = $arrivedGroups[$leavedGroupIndex];
        echo sprintf('Leaved group index %d and size %d', $leavedGroupIndex, $group->size()) . PHP_EOL;
        $restManager->onLeave($group);
        printTables($tables, $arrivedGroups);
    }
}

/**
 * @param array $dataProvider
 * @param ArrayOperation $arrayOperation
 * @param RuleInterface $rule
 * @param ClientsGroupRelationInterfaceFactory $clientGroupRelationFactory
 * @param ClientGroupQueueFactoryInterface $clientGroupQueueFactory
 */
function test(array $dataProvider, ArrayOperation $arrayOperation, RuleInterface $rule, ClientsGroupRelationInterfaceFactory $clientGroupRelationFactory, ClientGroupQueueFactoryInterface $clientGroupQueueFactory) {
    $index = 1;
    foreach ($dataProvider as $testData) {
        echo str_repeat('-', 50) . PHP_EOL;
        echo 'Test number ' . $index++ . ':' . PHP_EOL;
        echo str_repeat('-', 50) . PHP_EOL;
        $tables = new TableList($arrayOperation);
        foreach ($testData['tables'] as $tableSize) {
            $tables->add(new Table($tableSize, $clientGroupRelationFactory));
        }

        $arrivedGroups = [];
        foreach ($testData['arrived_groups'] as $groupIndex => $groupSize) {
            $arrivedGroups[$groupIndex] = new ClientsGroup($groupSize);
        }

        $restManager = new RestManager($tables, $rule, $clientGroupQueueFactory);

        testOnArriveGroups($restManager, $arrivedGroups, $tables);

        if (isset($testData['leaved_groups']) && is_array($testData['leaved_groups']) && count($testData['leaved_groups']) > 0) {
            testOnLeaveGroups($restManager, $arrivedGroups, $testData['leaved_groups'], $tables);
        }
    }
}

$arrayOperation = new ArrayOperation();
$clientGroupRelationFactory = new ClientsGroupRelationFactory($arrayOperation);
$clientsGroupQueueService = new ClientsGroupQueueService();
$clientsGroupQueueFactory = new ClientsGroupQueueFactory($arrayOperation);

$rule = new EmptyChairsTableRule(
    new BigAndSmallClientsGroupRule(
        $clientsGroupQueueService,
        new ShareEmptyChairsForSmallClientsGroupRule(
            $clientsGroupQueueService
        )
    )
);

$dataProvider = [
    [
        'tables' => [
            2, 3, 4, 5, 6
        ],
        'arrived_groups' => [
            1 => 1,
            21 => 2,
            22 => 2,
            23 => 2,
            3 => 3,
            41 => 4,
            42 => 4,
            51 => 5,
            52 => 5,
            6 => 6,
        ],
        'leaved_groups' => [
            41
        ]
    ],
    [
        'tables' => [
            2, 3, 4, 5, 6
        ],
        'arrived_groups' => [
            6 => 6,
            51 => 5,
            52 => 5,
            1 => 1,
            21 => 2,
            22 => 2,
            23 => 2,
            3 => 3,
            41 => 4,
            42 => 4,
        ],
        'leaved_groups' => [
            6
        ]
    ],
    [
        'tables' => [
            2, 3, 4, 5, 6
        ],
        'arrived_groups' => [
            6 => 6,
            51 => 5,
            52 => 5,
            11 => 1,
            21 => 2,
            22 => 2,
            23 => 2,
            24 => 2,
            12 => 1,
            4 => 4,
        ],
        'leaved_groups' => [
            11
        ]
    ],
    [
        'tables' => [
            2, 3, 4, 5, 6
        ],
        'arrived_groups' => [
            6 => 6,
            51 => 5,
            52 => 5,
            11 => 1,
            21 => 2,
            22 => 2,
            23 => 2,
            24 => 2,
            25 => 2,
            12 => 1,
            4 => 4,
        ],
        'leaved_groups' => [
            24
        ]
    ]
];

test($dataProvider,  $arrayOperation, $rule, $clientGroupRelationFactory, $clientsGroupQueueFactory);