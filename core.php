<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-05-09
 * Time: 19:28
 */

require_once ('include/ts3admin.class.php');
require_once ('config/config.php');
foreach (glob("functions/*.php") as $filename)
{
    require_once $filename;
}

$ts3 = new ts3admin($teamspeak['address'],$teamspeak['tcp']);

$ts3->connect();
$ts3->login($teamspeak['login'],$teamspeak['password']);
$ts3->selectServer($teamspeak['udp']);
$ts3->setName($config['bot']['name']);
$users = $ts3->getElement('data',$ts3->clientList('-groups -voice -away -times -uid'));

$count = 0;
while (true) {
    $core = $ts3->getElement('data', $ts3->whoAmI());
    //$ts3->clientMove($core['client_id'], $config['bot']['default_channel']);

    sleep(1);
    afk();
    welcomemsg();
    poke();
    createchannel();
    checkchannel();

}

	/*
	if($count >= 1000){
		gc_collect_cycles();
		$count=0;
	}
	*/
	
	


