<?php
namespace Reports;
use \PDO as PDO;

class Customers implements IManager
{

    protected $table = TABLE_CUSTOMERS;
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

        $stmt = $this->connection->prepare('INSERT INTO '.$this->table.' (name,type,document) VALUES(:name,:type,:document)');
        $stmt->bindValue(':name', $this->data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':document', $this->data['document'], PDO::PARAM_STR);
        $stmt->bindValue(':type', $this->data['type'], PDO::PARAM_STR);
        $stmt->execute();
        $this->data = $this->connection->lastInsertId();
    }

    protected function update(){
        $stmt = $this->connection->prepare('UPDATE '.$this->table.' SET name=:name, type=:type, document=:document WHERE id=:id');
        $stmt->bindValue(':id', $this->data['id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':document', $this->data['document'], PDO::PARAM_STR);
        $stmt->bindValue(':type', $this->data['type'], PDO::PARAM_STR);
        $stmt->execute();
        $this->data = $this->data['id'];
    }

    public function destroy($id){
        $stmt = $this->connection->prepare('call  '.PROCEDURE_DELETE_CUSTOMER.'(:id)');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllCustomers($search){
        $stmt = $this->connection->prepare('SELECT * FROM '.VIEW_CUSTOMERS.' where name like :search OR type like :search OR social_name like :search OR document like :search OR email like :search');
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
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