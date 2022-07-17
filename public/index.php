<?php 

require '../vendor/autoload.php';

use app\database\models\User;
use app\database\activerecord\Insert;
use app\database\activerecord\Update;
use app\database\activerecord\Delete;
use app\database\activerecord\FindBy;
use app\database\activerecord\FindAll;

$user = new User;

// $user->firstName = 'João';
// $user->lastName = 'Marcelo';

// echo $user->execute(new Update(field: 'id', value: 1));
// echo $user->execute(new Insert);
// echo $user->execute(new Delete(field: 'id', value: 1));
// print_r($user->execute(new FindBy(field: 'id', value: 2, columns: 'id, firstName')));
print_r($user->execute(new FindAll(where: ['id' => 2])));