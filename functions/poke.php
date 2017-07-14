<?php
/**
 * Created by PhpStorm.
 * User: s.manczak
 * Date: 05.06.2017
 * Time: 14:00
 */


function poke()
{

    global $ts3;
    global $config;

    static $time= array('interval'=> 0 );

    $clients = $ts3->getElement('data', $ts3->clientList('-groups -uid'));
    $channel = $ts3->getElement('data', $ts3->channelClientList($config['poke']['channel'], '-ip'));

    if (!empty($channel)) {
        foreach ($clients as $users) {

            $user_group_id = explode(',', $users['client_servergroups']);

            if ($users['client_nickname'] != $config['bot']['name']) {

                    if (isInGroup($user_group_id, $config['poke']['group'])) {
                        if($time['interval'] < time()) {
                            $ts3->clientPoke($users['clid'], "Ktoś czeka na kanale POMOCY !");
                            $time['interval'] = time()+$config['poke']['interval'];

                        }
                }


            }
        }


    }

    //print_r($time);

    unset($ts3);
    unset($config);
    unset($time);
    unset($clients);
    unset($channel);
    unset($users);
    unset($user_group_id);
}

function isInGroup($a, $b){
    for ($i=0; $i<count($a); $i++){

        if (in_array($a[$i],$b)){
            return 1;
        }
        else{
            return 0;
        }
    }

}

