<?php


class Bussiness extends Database
{
    protected $table = 'products'; //override

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(); //Gọi hàm __construct() của class Cha (Database)
        echo 'construct from Bussiness <br/>';
    }

    public function query()
    {
       parent::query();
        echo 'query bussiness <br/>';
    }

    public function getDetail()
    {
        $this->fetch();
    }

    public function getTable()
    {
        echo $this->table . '<br/>';
    }
}