<?php 

namespace app\database\activerecord\interfaces;

interface IActiveRecordExecute
{
  public function execute(IActiveRecord $activeRecordInterface);
}