<?php

namespace controllers;

class Index extends AbstractController
{
    public function get_main(\Base $base){
    
        $base->set("title", "Hlavní stránka"); //Nastavení proměnné "title", do které uložíme hodnotu "Hlavní stránka"
        $base->set("content","main.html"); //Uložení hodnoty "hlavni_stranka.html" do proměnné "content"
        // echo \Template::instance()->render("index.html"); // Vypsání "index.html", ve kterém je template html stránky//Vypís
    }
    

    public function get_prihlasit(\Base $base)
    {
        $base->set("title", "Přihlášení");
        $base->set("kids", 1);
        $base->set("parent", $base->get('logged'));
        $base->set("content","apply.html");
    }

    public function post_kids(\Base $base)
    {
        $amount = $base->get('PARAMS.num');
        $base->set('kids', $amount);
        $base->set("parent", $base->get('logged'));
        $base->set("content","apply.html");
    }

    public function post_prihlaska(\Base $base)
    {
        $data = $base->get('POST');

        $prihlaska = new \models\Prihlaska();
        $prihlaska->termin = $data['termin'];
        $prihlaska->rodic = $base->get('SESSION.user[id]');

        $rodic = new \models\Uzivatel();
        $rodic = $rodic->findone(array('id=?', $base->get('SESSION.user[id]')));
        $rodic->prihlaska[] = $prihlaska;
        $rodic->save();

        $kids = [];
        for($i = 0; $i < $data['pocet_deti']; $i++)
        {
            $dite = new \models\Dite();
            $dite->jmeno = $data['jmeno'][$i];
            $dite->prijmeni = $data['prijmeni'][$i];
            $dite->datum_narozeni = $data['datum_narozeni'][$i];
            $dite->tshirt_size = $data['tshirt_size'][$i];

            $dite->rodic = $base->get('SESSION.user[id]');
            // $dite->prihlaska[] = $prihlaska;
            array_push($kids, $dite);

            $dite->save();
        }
        $prihlaska->kids = $kids;
        $prihlaska->save();

        $base->reroute('/');
    }

}