<?php

namespace models;

class Dite extends \DB\Cortex
{
    protected $db = 'DB';
    protected $table = 'dite';
    protected $primary = 'id';

    protected $fieldConf = [
        'jmeno' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'prijmeni' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'datum_narozeni' => [
            'type' => 'DATE',
            'nullable' => false,
        ],
        'tshirt_size' => [
            'type' => 'VARCHAR128',
            'nullable' => false,
        ],
        'prihlaska' => [
            'has-many' => ['\models\Prihlaska','kids'],
        ],
        'rodic' => [
            'belongs-to-one' => '\models\Uzivatel'
        ],
    ];
}