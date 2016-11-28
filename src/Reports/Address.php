<?php
namespace Reports;
use \PDO as PDO;

class Address implements IManager
{

    protected $table = TABLE_CUSTOMER_ADDRESS;
    public $connection;
    public $data = null;

    public function __construct()
    {
        $this->connection =  Connection::getInstance();
    }

    public function save($data){

        $this->data = $data;
        $stmt = $this->connection->prepare('INSERT INTO '.$this->table.' (customer_id,address) VALUES(:customer_id,:address)');
        $stmt->bindValue(':customer_id', $this->data['customer_id'], PDO::PARAM_INT);
        $stmt->bindValue(':address', $this->data['address'], PDO::PARAM_STR);
        $stmt->execute();
        $this->data = $this->connection->lastInsertId();
    }


    public function destroy($customer_id){
        $stmt = $this->connection->prepare('DELETE FROM '.$this->table.' where customer_id=:customer_id');
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllAddress(){
        $stmt = $this->connection->prepare('SELECT * FROM '.$this->table);
        $stmt->execute();
        $this->data = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAddressById($customer_id){
        $stmt = $this->connection->prepare('SELECT * FROM '.$this->table.' where customer_id=:customer_id');
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->data = $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}