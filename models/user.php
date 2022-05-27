<?php
require "database_config.php";
require "orm.php";

class User extends MysqlAdapter
{

    private $table = "users";

    public function __construct()
    {
        global $config ;
        // call parent constructor 
        parent :: __construct($config);
    }
    public function getUsers()
    {
        $this->select($this->table);
        return $this->fetchAll();
    }
    public function getUser($user_id)
    {
        $this->select($this->table,' id= '.$user_id);
        return $this->fetch();
    }
    public function addUser(array $user_data)
    {
        $this->insert($this->table,$user_data);
    }
    public function updateUser($user_id,array $user_data)
    {
        $this->update($this->table,$user_data,' id= '.$user_id);   
    }
    public function deleteUser($user_id)
    {
        $this->delete($this->table,' id= '.$user_id);
    }
    public function searchUsers($keyword)
    {
        $this->select($this->table," name like '%".$keyword."%' or email like '%".$keyword."%'");
        return $this->fetchAll();
    }
}

?>