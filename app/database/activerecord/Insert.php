<?php 

namespace app\database\activerecord;

use Throwable;
use app\database\connection\Connection;
use app\database\activerecord\interfaces\IActiveRecord;
use app\database\activerecord\interfaces\IActiveRecordExecute;

class Insert implements IActiveRecordExecute
{
  public function execute(IActiveRecord $activeRecordInterface)
  {
    try {
      $query = $this->createQuery($activeRecordInterface);

      $connection = Connection::connect();

      $prepare = $connection->prepare($query);
      return $prepare->execute($activeRecordInterface->getAttributes());
    } catch (Throwable $th) {
      formatException($th);
    }
  }

  private function createQuery(IActiveRecord $activeRecordInterface)
  {
    $sql = "INSERT INTO {$activeRecordInterface->getTable()} (";
    $sql .= implode(', ', array_keys($activeRecordInterface->getAttributes())) . ') VALUES (';
    $sql .= ':' . implode(', :', array_keys($activeRecordInterface->getAttributes())) . ')';

    return $sql;
  }
}