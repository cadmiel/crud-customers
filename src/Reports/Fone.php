<?php
namespace Reports;
use \PDO as PDO;

class Fone implements IManager
{

    protected $table = 'customer_fone';
    public $connection;
    public $data = null;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function save($data)
    {

        $this->data = $data;
        $stmt = $this->connection->prepare('INSERT INTO ' . $this->table . ' (customer_id,fone) VALUES(:customer_id,:fone)');
        $stmt->bindValue(':customer_id', $this->data['customer_id'], PDO::PARAM_INT);
        $stmt->bindValue(':fone', $this->data['fone'], PDO::PARAM_STR);
        $stmt->execute();
        $this->data = $this->connection->lastInsertId();
    }


    public function destroy($customer_id)
    {
        $stmt = $this->connection->prepare('DELETE FROM ' . $this->table . ' where customer_id=:customer_id');
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllFone()
    {
        $stmt = $this->connection->prepare('SELECT * FROM ' . $this->table);
        $stmt->execute();
        $this->data = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFoneById($customer_id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM ' . $this->table . ' where customer_id=:customer_id');
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->data = $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}