<?php

namespace app\database\activerecord;

use Throwable;
use app\database\connection\Connection;
use app\database\activerecord\interfaces\IActiveRecord;
use app\database\activerecord\interfaces\IActiveRecordExecute;

class FindBy implements IActiveRecordExecute
{
  public function __construct(
    private string $field, 
    private string|int $value, 
    private string $columns = '*'
  )
  {
  }

  public function execute(IActiveRecord $activeRecordInterface)
  {
    try {
      $query = $this->createQuery($activeRecordInterface);

      $connection = Connection::connect();
      
      $prepare = $connection->prepare($query);
      $prepare->execute([
        $this->field => $this->value
      ]);

      return $prepare->fetch();
    } catch (Throwable $th) {
      formatException($th);
    }
  }

  private function createQuery(IActiveRecord $activeRecordInterface)
  {
    $sql = "SELECT {$this->columns} FROM {$activeRecordInterface->getTable()} WHERE ";
    $sql .= "{$this->field} = :{$this->field}";

    return $sql;
  }
}
