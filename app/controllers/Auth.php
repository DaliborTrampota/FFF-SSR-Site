<?php

namespace controllers;

class Auth
{

    public function get_login(\Base $base)
    {
        $base->set("title", "Přihlášení");
        $base->set("content","login.html");
    }

    public function get_register(\Base $base)
    {
        $base->set("title", "Registrace");
        $base->set("content","register.html");
    }


    public function post_login(\Base $base)
    {
        $email = $base->get('POST.email');
        $password = $base->get('POST.heslo');

        $u = new \models\Uzivatel();
        $u = $u->findone(array('email=?', $email));

        $base->get('logger')->write($email, $password);

        if ($u !== false && password_verify($password, $u->heslo)) {
            $base->clear('SESSION.user');
            $base->set('SESSION.user', $u->cast());
            $base->set('SESSION.user["id"]', $u->id);
            $base->reroute('/');
        } else {
            $base->reroute('/login');
        }
    }

    public function post_register(\Base $base)
    {
        $email = $base->get('POST.email');
        $password = $base->get('POST.heslo');
        $name = $base->get('POST.name');
        $surname = $base->get('POST.surname');
        $phone = $base->get('POST.phone');

        $u = new \models\Uzivatel();
        $u->email = $email;
        $u->jmeno = $name;
        $u->prijmeni = $surname;
        $u->tel = $phone;
        $u->heslo = $password;
        $u->save();

        $base->clear('SESSION.user');
        $base->set('SESSION.user', $u->cast());
        $base->set('SESSION.user["id"]', $u->id);
        $base->reroute('/');
    }

    public function get_install(\Base $base)
    {
        \models\Uzivatel::setdown();
        \models\Prihlaska::setdown();
        \models\Dite::setdown();

        \models\Uzivatel::setup();
        \models\Dite::setup();
        \models\Prihlaska::setup();
        
        \models\Uzivatel::install($base->get('ADMIN_EMAIL'), 'admin');

        $base->reroute('/');
    }
    
    public function afterRoute()
    {
        echo \Template::instance()->render("index.html");
    }
}