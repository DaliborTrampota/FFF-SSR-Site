<?php

namespace controllers;

class Secure
{

    public function get_admin_list(\Base $base)
    {
        $prihlasky = new \models\Prihlaska();
        $prihlasky = $prihlasky->afind();

        $base->set("title", "List přihlášek");
        $base->set("prihlasky", $prihlasky);
        
        $base->set("parent", $base->get('logged'));
        $base->set("content","admin_list.html");
    }

    public function beforeRoute(\Base $base)
    {
        if (!$base->get('SESSION.user')) {
            $base->reroute('/login');
        }

        $uid = \Base::instance()->get('SESSION.user[id]');
        $u = new \models\Uzivatel();
        $u = $u->findone(array('id=?', $uid));
        
        if($u === false || !$u->admin) {
            $base->reroute('/login');
        }
    }
    
    public function afterRoute()
    {
        echo \Template::instance()->render("index.html");
    }

}