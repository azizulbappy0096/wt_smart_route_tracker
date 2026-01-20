<?php
require_once BASE_PATH . '/core/Model.php';

class AlertsModel extends Model
{
    function __construct($table = 'alerts')
    {
        $this->table = $table;
    }
}
