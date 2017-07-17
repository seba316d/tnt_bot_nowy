<?php
/**
 * Created by PhpStorm.
 * User: s.manczak
 * Date: 11.07.2017
 * Time: 14:31
 */

function checkchannel(){

    global $ts3;
    global $config;
    static $time= array('interval'=> 0 );

    $channel_list = $ts3->getElement('data',$ts3->channelList('-topic -flags -voice -limits -icon'));
    $channel_group_list = $ts3->getElement('data',$ts3->channelGroupClientList());

    if ($time['interval'] < time()) {
        foreach ($channel_list as $channels) {
                if ($channels['pid'] == $config['create_channel']['zone']) {
                    //Pobieranie daty z kanału
                    $data_kanal = strtotime($channels['channel_topic']);
                    $data_kanal_max = strtotime('+6 days', $data_kanal);
                    $obecna_data = time();

                // Sprawdznie czy data nie jest za stara jak tak to zmieniamy kanał na wolny
                    if ($channels['channel_topic'] != "wolny") {
                        if ($data_kanal_max <= $obecna_data) {
                            $channel_name = (integer)$channels['channel_name'];
                            $data = array(
                                'channel_name' => $channel_name . ".wolny",
                                'CHANNEL_TOPIC' => "wolny"
                            );

                            $ts3->channelEdit($channels['cid'], $data);
                            remove_group($channel_group_list, $channels['cid'], $config, $ts3);
                            delete_sub_channel($channel_list, $channels['cid'], $ts3);
                            $time['interval'] = time() + $config['create_channel']['interval'];
                        } else // Jeżeli data jest stara aktualizuje date
                        {

                            if ($channels['total_clients'] > 0 || check_sub_channel($channel_list, $channels['cid'])) {
                                if ($channels['channel_topic'] < date('d.m.Y', time())) {
                                    $data = array(
                                        'CHANNEL_TOPIC' => date('d.m.Y')
                                    );

                                    $ts3->channelEdit($channels['cid'], $data);
                                }
                            }
                            $time['interval'] = time() + $config['create_channel']['interval'];
                        }
                    }
                }
            }

    }

}

function remove_group($channel_group_list,$channel_id,$config,$ts3)
{
    foreach ($channel_group_list as $channel_group)
    {
        if($channel_group['cid'] == $channel_id){
            $ts3->setClientChannelGroup(8,$channel_id,$channel_group['cldbid']);
        }
    }
}

function delete_sub_channel($channel_list,$channel_id,$ts3)
{
    foreach ($channel_list as $channel)
    {
        if($channel['pid'] == $channel_id)
        {
            $ts3->channelDelete($channel['cid']);
        }
    }
}

function check_sub_channel($channel_list,$channel_id)
{
    foreach ($channel_list as $channels)
    {
        if($channels['pid'] == $channel_id)
        {
            if ($channels['total_clients'] > 0)
            {
                return 1;
            }
        }
    }
    return 0;
}
