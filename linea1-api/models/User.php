<?php namespace Models;

class User extends _model
{

    public $id = 0;
    public $id_role;
    public $name;
    public $surname;
    public $username;
    protected $password; // Protegido, no se imprime
    public $token;
    public $state;
    public $date_created;

    //protected $hidden = ['password'];

    public function root()
    {
        return $this->username == 'root';
    }

    public function password()
    {
        return $this->password;
    }

}