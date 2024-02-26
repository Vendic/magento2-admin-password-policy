<?php
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

$datetime = $objectManager->create(\Magento\Framework\Stdlib\DateTime::class);
$userResource = $objectManager->create(Magento\User\Model\ResourceModel\User::class);

$user = $objectManager->create(\Magento\User\Model\User::class);
$user->setUserName('expired_dummy_user');
$user->setFirstName('John');
$user->setLastName('Doe');
$user->setEmail('email@example.com');
$user->setPassword('Letmein123!');
$user->setLogdate('2023-01-01 00:00:00');
$userResource->save($user);

$now = new \DateTime();
$currentDatetime = $datetime->formatDate($now);

$user = $objectManager->create(\Magento\User\Model\User::class);
$user->setUserName('recently_used_dummy_user');
$user->setFirstName('Jane');
$user->setLastName('Doe');
$user->setEmail('mail@example.com');
$user->setPassword('Letmein123!');
$user->setLogdate($currentDatetime);
$userResource->save($user);
