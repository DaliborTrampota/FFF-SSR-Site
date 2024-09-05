<?php

namespace models;

class Prihlaska extends \DB\Cortex
{
    protected $db = 'DB';
    protected $table = 'prihlaska';
    protected $primary = 'id';

    protected $fieldConf = array(
        'rodic' => [
            'belongs-to-one' => '\models\Uzivatel'
        ],
        'termin' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'kids' => [
            'has-many' => ['\models\Dite','prihlaska'],
        ],
        "vytvorena" => array(
            'type' => 'TIMESTAMP',
            'nullable' => true,
            'default' => \DB\SQL\Schema::DF_CURRENT_TIMESTAMP
        ),
    );
}