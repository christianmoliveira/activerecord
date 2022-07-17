<?php

namespace app\database\activerecord;

use Throwable;
use app\database\connection\Connection;
use app\database\activerecord\interfaces\IActiveRecord;
use app\database\activerecord\interfaces\IActiveRecordExecute;
use Exception;

class FindAll implements IActiveRecordExecute
{
  public function __construct(
    private array $where = [],
    private string|int $limit = '',
    private string|int $offset = '',
    private string $columns = '*'
  ) {
  }

  public function execute(IActiveRecord $activeRecordInterface)
  {
    try {
      $query = $this->createQuery($activeRecordInterface);

      $connection = Connection::connect();

      $prepare = $connection->prepare($query);
      $prepare->execute($this->where);

      return $prepare->fetchAll();
    } catch (Throwable $th) {
      formatException($th);
    }
  }

  private function createQuery(IActiveRecord $activeRecordInterface)
  {
    if (count($this->where) > 1) {
      throw new Exception('No where só pode passar um índice');
    }

    $where = array_keys($this->where);
    $sql = "SELECT {$this->columns} FROM {$activeRecordInterface->getTable()}";
    $sql .= (!$this->where) ? '' : " WHERE {$where[0]} = :{$where[0]}";
    $sql .= (!$this->limit) ? '' : " LIMIT {$this->limit}";
    $sql .= ($this->limit != '') ? " OFFSET {$this->offset}" : '';

    return $sql;
  }
}
