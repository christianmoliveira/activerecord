<?php 

namespace app\database\activerecord;

use Throwable;
use Exception;
use app\database\connection\Connection;
use app\database\activerecord\interfaces\IActiveRecord;
use app\database\activerecord\interfaces\IActiveRecordExecute;

class Update implements IActiveRecordExecute
{
  public function __construct(private string $field, private string $value)
  {
  }

  public function execute(IActiveRecord $activeRecordInterface)
  {
    try {
      $query = $this->createQuery($activeRecordInterface);

      $connection = Connection::connect();

      $attributes = array_merge($activeRecordInterface->getAttributes(), [
        $this->field => $this->value,
      ]);

      $prepare = $connection->prepare($query);
      $prepare->execute($attributes);

      return $prepare->rowCount();
    } catch(Throwable $th) {
      formatException($th);
    }
  }

  private function createQuery(IActiveRecord $activeRecordInterface)
  {
    if (array_key_exists('id', $activeRecordInterface->getAttributes())) {
      throw new Exception("O campo id não pode ser passado para o Update");
    }

    $sql = "update {$activeRecordInterface->getTable()} set ";

    foreach ($activeRecordInterface->getAttributes() as $key => $value) {
      $sql .= "{$key} = :{$key}, ";
    }

    $sql = rtrim($sql, ', ');
    $sql .= " where {$this->field} = :{$this->field}";

    return $sql;
  }
}