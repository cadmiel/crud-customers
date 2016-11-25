<?php
namespace Reports;
use \PDO as PDO;
use \PDOException as PDOException;

class Connection
{

    public static $instance;

    public static function getInstance()
    {
        try {
            if (!isset(self::$instance)) {
                self::$instance = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec('SET NAMES utf8');
            }

            return self::$instance;

        } catch (PDOException $e) {

            return $e->getMessage();
        }
    }

}