<?php


class Person
{
    private $name = "Dương";
    private $email = "duong@gmail.com";

    public function __get($name)
    {
        return $this->name;
    }

    public function __set($name, $value)
    {
        $this->name = $value;

    }

    private function getName()
    {
        return $this->name;
    }

    private function setName($name)
    {
        $this->name = $name;

    }

    private function setEmail($email)
    {
        $this->email = $email;

    }


    public function __call($method, $args)
    {
        return call_user_func_array([
            $this, $method
        ], $args
        );
    }
}

$person = new Person();
$person->setName('duongx1801');
