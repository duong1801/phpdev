<?php


class Database
{
    protected $table = 'users';
    /**
     * Class constructor.
     */
    public function __construct()
    {
        echo 'construct database class <br/>';
    }

    public function query()
    {
        echo 'query database <br/>';
    }

    public function fetch()
    {
        echo 'fetch method from database <br/>';
    }

    public function getFullInfo()
    {
        //echo 'getFullInfo method from database <br/>';
        $this->getDetail();
    }

    public function getTableFromDb()
    {
        echo $this->table.'<br/>';
    }
}