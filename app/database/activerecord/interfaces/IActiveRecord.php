<?php 

namespace app\database\activerecord\interfaces;

interface IActiveRecord
{
  public function execute(IActiveRecordExecute $activeRecordExecute);
  public function __set($attribute, $value);
  public function __get($attribute);
  public function getTable();
  public function getAttributes();
}