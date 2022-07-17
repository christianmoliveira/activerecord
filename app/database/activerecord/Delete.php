<?php

namespace app\database\activerecord;

use Throwable;
use Exception;
use app\database\connection\Connection;
use app\database\activerecord\interfaces\IActiveRecord;
use app\database\activerecord\interfaces\IActiveRecordExecute;

class Delete implements IActiveRecordExecute
{
  public function __construct(private string $field, private string|int $value)
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
    } catch (Throwable $th) {
      formatException($th);
    }
  }

  private function createQuery(IActiveRecord $activeRecordInterface)
  {
    if ($activeRecordInterface->getAttributes()) {
      throw new Exception('Para deletar não precisa passar atributos.');
    }

    $sql = "DELETE FROM {$activeRecordInterface->getTable()} WHERE ";
    $sql .= "{$this->field} = :{$this->field}";

    return $sql;
  }
}
