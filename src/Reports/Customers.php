<?php

namespace Reports;
use \PDO as PDO;

class Customers implements IManager
{

    protected $table = 'customers';
    public $connection;
    public $data = null;

    public function __construct()
    {
        $this->connection =  Connection::getInstance();
    }

    public function save($data){

        $this->data = $data;

        if(is_array($this->data) AND isset($this->data['id']) AND $this->data['id'] != 0)
            return $this->update();

        $stmt = $this->connection->prepare('INSERT INTO '.$this->table.' (name) VALUES(:name)');
        $stmt->bindValue(':name', $this->data['name'], PDO::PARAM_STR);
        $stmt->execute();
        $this->data = $this->connection->lastInsertId();
    }

    protected function update(){
        $stmt = $this->connection->prepare('UPDATE '.$this->table.' SET name=:name WHERE id=:id');
        $stmt->bindValue(':id', $this->data['id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->data['name'], PDO::PARAM_STR);
        $stmt->execute();
        $this->data = $this->data['id'];
    }

    public function destroy($id){
        $stmt = $this->connection->prepare('DELETE FROM '.$this->table.' where id=:id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllCustomers(){
        $stmt = $this->connection->prepare('SELECT * FROM '.$this->table);
        $stmt->execute();
        $this->data = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCustomerById($id){
        $stmt = $this->connection->prepare('SELECT * FROM '.$this->table.' where id=:id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $this->data = $stmt->fetch(PDO::FETCH_OBJ);
    }


}