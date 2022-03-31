<?php

/**
 * This file model configuration for the application.
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Orkhan Shafizada
 */

namespace App\Core;

use App\Core\DB;
use App\Models\Users;

class QueryBuilder
{
    /**
     * @var null
     */
    protected static $table = null;

    /**
     * @var
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        $arr = [];
        $result = DB::fetchAll(self::getTable());
        foreach ($result as $r) {
            $arr[] = (object)$r;
        }

        return $arr;
    }


    /**
     * @param int $id
     * @return array
     */
    public static function find(int $id): array
    {
        $db = DB::get_instance();
        $conn = $db->get_connection();
        $sth = $conn->prepare("SELECT * FROM " . self::getTable() . " WHERE id = $id");
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * Displays the name of the table in the database according to the class called
     * @return string
     */
    public static function getTable(): string
    {
        if (self::$table != null) {
            return self::$table;
        }
        $cls = get_called_class();
        $cls = explode('\\', $cls);

        return strtolower(end($cls));
    }


    /**
     * @param array $data
     * @return array
     */
    public static function insert(array $data): array
    {
        $db = DB::get_instance();
        $conn = $db->get_connection();

        $getColumnsKeys = array_keys($data);
        $implodeColumnKeys = implode(",",$getColumnsKeys);

        $getValues = array_values($data);
        $implodeValues = "'".implode("','",$getValues)."'";

        $table = self::getTable();
        $qry = "insert into $table (".$implodeColumnKeys.") values (".$implodeValues.")";
        $conn->query($qry);


        $lastInsertData = self::find($conn->lastInsertId());
        return $lastInsertData;
    }
}