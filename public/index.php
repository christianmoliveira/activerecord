<?php 

require '../vendor/autoload.php';

use app\database\models\User;
use app\database\activerecord\Update;

$user = new User;

$user->firstName = 'Maria';
$user->lastName = 'Clara';

// echo $user->execute(new Update(field: 'id', value: 1));