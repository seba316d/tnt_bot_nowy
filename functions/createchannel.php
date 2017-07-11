<?php
/**
 * Created by PhpStorm.
 * User: s.manczak
 * Date: 05.07.2017
 * Time: 13:21
 */

function createchannel(){
    global $ts3;
    global $config;


    $channel_admin_list = $ts3->getElement('data',$ts3->channelGroupClientList());
    $client_list = $ts3->getElement('data', $ts3->clientList());

    echo'<pre>';
    //print_r($channel_admin_list);
    echo '</pre>';

            foreach ($client_list as $cldbi) {
                if($cldbi['cid'] == $config['create_channel']['channel']) { // sprawdzam czy uzytkownik siedzi na kanale "stworz kanal"
                foreach ($channel_admin_list as $channel_cldbi) {

                    if ($cldbi['client_database_id'] == $channel_cldbi['cldbid']) {
                        $ts3->sendMessage(1,$cldbi['clid'],"Posiadaz juz kanał na tym TS!!");
                        $ts3->clientMove($cldbi['clid'],$channel_cldbi['cid']);
                        $ts3->sendMessage(1,$cldbi['clid'],"Zostales przeniesiony na swoj kanal. Milej zabawy");
                        $do_create_channel = FALSE;
                        break;
                    }
                    else{
                        $do_create_channel = true;
                    }
                }
                if($do_create_channel==true){
                        $data = array(
                            'channel_flag_permanent'=>1,
                            'channel_name'=>$cldbi['client_nickname'],
                            'cpid'=>$config['create_channel']['zone'],
                            'CHANNEL_TOPIC'=>date('d.m.Y')
                        );
                        $channel_created = $ts3->getElement('data',$ts3->channelCreate($data));

                        if($config['create_channel']['sub-channel_create']) {
                            for ($i = 0; $i < $config['create_channel']['sub-channel']; $i++) {
                                $data = array(
                                    'channel_flag_permanent' => 1,
                                    'channel_name' => ++$i . ".Podkanał",
                                    'cpid' => $channel_created['cid']
                                );
                                --$i;
                                $ts3->channelCreate($data);
                            }
                        }

                        $ts3->setClientChannelGroup($config['create_channel']['channel_group'],$channel_created['cid'],$cldbi['client_database_id']);
                        $ts3->clientMove($cldbi['clid'],$channel_created['cid']);
                }




            }
    }



}