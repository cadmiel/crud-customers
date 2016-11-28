<?php
namespace Reports;
use \PDO as PDO;

class SocialName implements IManager
{

    protected $table = TABLE_CUSTOMER_SOCIAL_NAME;
    public $connection;
    public $data = null;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function save($data)
    {

        $this->data = $data;
        $stmt = $this->connection->prepare('INSERT INTO ' . $this->table . ' (customer_id,social_name) VALUES(:customer_id,:social_name)');
        $stmt->bindValue(':customer_id', $this->data['customer_id'], PDO::PARAM_INT);
        $stmt->bindValue(':social_name', $this->data['social_name'], PDO::PARAM_STR);
        $stmt->execute();
        $this->data = $this->connection->lastInsertId();
    }


    public function destroy($customer_id)
    {
        $stmt = $this->connection->prepare('DELETE FROM ' . $this->table . ' where customer_id=:customer_id');
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllSocialName()
    {
        $stmt = $this->connection->prepare('SELECT * FROM ' . $this->table);
        $stmt->execute();
        $this->data = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getSocialNameById($customer_id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM ' . $this->table . ' where customer_id=:customer_id');
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->data = $stmt->fetch(PDO::FETCH_OBJ);
    }


}