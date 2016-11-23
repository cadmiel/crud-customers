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
                self::$instance = new PDO('mysql:host=localhost;dbname=Reports', 'root', '');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec('SET NAMES utf8');
            }

            return self::$instance;

        } catch (PDOException $e) {

            return $e->getMessage();
        }
    }

}