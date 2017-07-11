<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-05-11
 * Time: 17:44
 */

require_once ('config/config.php');
require_once ('include/ts3admin.class.php');


function welcomemsg(){

    global $ts3;
    global $clients;

        $clients['new'] = clientlist();
        //$clients['old'] = array(); // Przypisuje nowych uzytkownikow do starych czyli tych co juz weszli ;

        if (isset($clients['old'])) {
            $clients['difference'] = array_diff($clients['new'], $clients['old']);
        } else {
            $clients['difference'] = array();
        }

//echo count($clients['difference']);

        if (count($clients['difference']) != 0) {
            foreach ($clients['difference'] as $clid) {
                $total_connect = $ts3->getElement('data',$ts3->clientInfo($clid));
                $ts3->sendMessage(1, $clid, '\nWitamy na Serwerze [b]OurDestiny ![/b] :) Życzymy udanych rozmów\n Twoja łączna liczba połączeń to:[b]'.$total_connect['client_totalconnections'].'[/b]');
                break;
            }
        }
        else{

        }

        $clients['old'] = $clients['new']; // Przypisuje nowych uzytkownikow do starych czyli tych co juz weszli ;
		unset($ts3);
		unset($clients);
		unset($clid);
		unset($total_connect);

}

function clientlist() {

    global $ts3;

    $clients['all'] = $ts3->getElement('data', $ts3->clientList());

    $clients['recent'] = array();
    foreach($clients['all'] as $client) {

        if($client['client_type'] == 0) {
            array_push($clients['recent'], $client['clid']);
        }
    }

    return $clients['recent'];
}