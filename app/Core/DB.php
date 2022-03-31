<?php
/**
 * This file database connection and configuration for the application.
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Orkhan Shafizada
 */
namespace App\Core;

use PDO;

class DB
{

    /**
     * @var null
     */
    private static $instance = null;
    /**
     * @var PDO
     */
    private $conn;


    public function __construct()
    {
        $this->conn = new PDO(
            'mysql:dbname='. $_ENV['DB_DATABASE'] .
            ';host=' . $_ENV['DB_HOST'] .
            ';charset=UTF8',
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD'],
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
        );
    }


    /**
     * @return DB|null
     */
    public static function get_instance()
    {
        if( self::$instance == null )
        {
            self::$instance = new DB();
        }
        return self::$instance;
    }


    /**
     * @return PDO
     */
    public function get_connection(): PDO
    {
        return $this->conn;
    }


    /**
     * fetch all data from table
     *
     * @param $tableName
     * @return array|false
     */
    public static function fetchAll($tableName )
    {
        $db = DB::get_instance();
        $conn = $db->get_connection();

        $sth = $conn->prepare("SELECT * FROM " . $tableName );


        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }
}