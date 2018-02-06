<?php

namespace App\Services;

trait DataTableService
{
    public function dataTable($model, $fieldsOrSql = ['*'], $param = [], $condition = [], $sortFields = [] , callable $recombine = null)
    {
        return (new $model())->dataTable($fieldsOrSql, $param, $condition, $sortFields, $recombine);
    }
}
?>