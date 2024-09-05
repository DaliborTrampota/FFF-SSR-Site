<?php

namespace controllers;

class AbstractController
{

    protected $doRender = true;

    public function beforeRoute(\Base $base)
    {
        if (!$base->get('SESSION.user')) {
            $base->reroute('/login');
        }

        $uid = \Base::instance()->get('SESSION.user[id]');
        $u = new \models\Uzivatel();
        $u = $u->findone(array('id=?', $uid));
        
        if($u === false) {
            $base->reroute('/login');
        }

        $base->set('logged', $u);
    }

    public function afterRoute()
    {
        echo \Template::instance()->render("index.html");
    }
}