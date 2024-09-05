<?php

namespace models;

class Uzivatel extends \DB\Cortex
{
    protected $db = 'DB';
    protected $table = 'uzivatel';
    protected $primary = 'id';

    protected $fieldConf = [
        'email' => [
            'type' => 'TEXT',
            'nullable' => false,
            'unique' => true,
            'index'=>true
        ],
        'jmeno' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'prijmeni' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'tel' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'heslo' => [
            'type' => 'TEXT',
            'nullable' => false,
        ],
        'admin' => [
            'type' => 'BOOLEAN',
            'nullable' => false,
            'default' => false,
        ],
        'prihlaska' => [
            'has-many' => ['\models\Prihlaska','rodic'],
        ],
        'dite' => [
            'has-many' => ['\models\Dite','rodic'],
        ],
    ];

    public function set_heslo($value) {
        return password_hash($value, PASSWORD_DEFAULT); //Zahashuje hodnotu (heslo)
    }

    static public function install($email, $password, $db = null, $table = null, $fields = null)
    {
        $parent = parent::setup($db, $table, $fields);
        if ($parent) {
            $admin = new Uzivatel();
            $admin->email = $email;
            $admin->jmeno = "Admin";
            $admin->prijmeni = "Admin";
            $admin->heslo = $password;
            $admin->admin = true;
            $admin->save();
        }
    }
}