<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-05-09
 * Time: 20:42
 */
//require_once ('../include/ts3admin.class.php');
//require_once('config/config.php');

function afk()
{
    global $ts3;
    global $config;
    global $clientchannel;

    $users = $ts3->getElement('data', $ts3->clientList('-groups -voice -away -times -uid'));

    foreach ($users as $client) {


        if ($client['client_output_muted'] == 1) {
            if($client['cid'] != $config['afk']['channel']) {
                $clientchannel[$client['client_unique_identifier']] = $client['cid'];
            }
            $ts3->clientMove($client['clid'],$config['afk']['channel']);


        }
        else{
                usleep(2000);
                @$ss = $ts3->clientMove($client['clid'], $clientchannel[$client['client_unique_identifier']]);
                if($ss['success']) {
                    unset($clientchannel[$client['client_unique_identifier']]);
                    unset($ss);
                }
        }
    }
	
	unset($config);
	unset($ts3);
	unset($users);
	unset($client);
	
}