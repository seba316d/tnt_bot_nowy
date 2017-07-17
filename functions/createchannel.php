<?php
/**
 * Created by PhpStorm.
 * User: s.manczak
 * Date: 05.07.2017
 * Time: 13:21
 */

function createchannel()
{

    global $ts3;
    global $config;

    $channel_admin_list = $ts3->getElement('data', $ts3->channelGroupClientList());
    $client_list = $ts3->getElement('data', $ts3->clientList());
    $channel_list = $ts3->getElement('data', $ts3->channelList('-topic -flags -voice -limits -icon'));



    foreach ($client_list as $cldbi) {



        //Sprawdza czy mamy juz kanal
        if ($cldbi['cid'] == $config['create_channel']['channel']) { // sprawdzam czy uzytkownik siedzi na kanale "stworz kanal"

            $czy_topic_wolny = czy_topic_wolny($channel_list,$config);
            $czy_ma_kanal = czy_ma_kanal($cldbi['client_database_id'], $channel_admin_list);
            $numer_kanalu = numer_kanalu($channel_list,$config);

            if ($czy_ma_kanal['odpowiedz']) {
                $ts3->sendMessage(1, $cldbi['clid'], "Posiadaz juz kanał na tym TS!!");
                $ts3->clientMove($cldbi['clid'], $czy_ma_kanal['channel_id']);
                $ts3->sendMessage(1, $cldbi['clid'], "Zostales przeniesiony na swoj kanal. Milej zabawy");
            }
            //Sprawdza czy jakis kanal jest wolny jezeli tak to daje go uzytkownikowi
            if($czy_ma_kanal['odpowiedz'] != 1 && $czy_topic_wolny['odpowiedz']==1)
            {
                $ts3->sendMessage(1, $cldbi['clid'], "\nZa chwilkę Twoj kanał zostanie utworzony. \n [b]Życzymy udanych rozmów [/b]");

                if($czy_topic_wolny['odpowiedz'])
                {
                    $channel_number = (integer)$czy_topic_wolny['channel_name'];
                    $data = array(
                        'channel_name' => $channel_number . "." . $cldbi['client_nickname'],
                        'CHANNEL_TOPIC' => date('d.m.Y')
                    );

                    $ts3->getElement('data', $ts3->channelEdit($czy_topic_wolny['channel_id'], $data));

                    if ($config['create_channel']['sub-channel_create']) {
                        for ($i = 0; $i < $config['create_channel']['sub-channel']; $i++) {
                            $data = array(
                                'channel_flag_permanent' => 1,
                                'channel_name' => ++$i . ".Podkanał",
                                'cpid' => $czy_topic_wolny['channel_id']
                            );
                            --$i;
                            $ts3->channelCreate($data);
                        }
                    }

                    $ts3->setClientChannelGroup($config['create_channel']['channel_group'], $czy_topic_wolny['channel_id'], $cldbi['client_database_id']);
                    $ts3->clientMove($cldbi['clid'], $czy_topic_wolny['channel_id']);
                    $ts3->sendMessage(1, $cldbi['clid'], "Twoj Kanał został utworzony. Aby data była zaktualizowana należy wejść na kanał główny ");
                    sleep(1);

                }

            }
            // tworzy kanał jeżeli nie ma żadnego wolnego i klient nie ma pokoju
            if($czy_ma_kanal['odpowiedz'] == 0 && $czy_topic_wolny['odpowiedz'] == 0)
            {
                $data = array(
                    'channel_flag_permanent' => 1,
                    'channel_name' => ++$numer_kanalu['channel_number'] . "." . $cldbi['client_nickname'],
                    'cpid' => $config['create_channel']['zone'],
                    'CHANNEL_TOPIC' => date('d.m.Y')
                );

                $channel_created = $ts3->getElement('data', $ts3->channelCreate($data));

                if ($config['create_channel']['sub-channel_create']) {
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

                $ts3->setClientChannelGroup($config['create_channel']['channel_group'], $channel_created['cid'], $cldbi['client_database_id']);
                $ts3->clientMove($cldbi['clid'], $channel_created['cid']);
                break;
            }


        }
    }


}


    function czy_ma_kanal($cldbi, $channel_admin_list)
    {
        foreach ($channel_admin_list as $channel_list)
        {
            if($cldbi==$channel_list['cldbid'])
            {
                return array("odpowiedz"=>1, "channel_id"=>$channel_list['cid']);
            }

        }
        return array("odpowiedz"=>0);
    }

    function czy_topic_wolny($channel_list,$config)
    {
        foreach ($channel_list as $channel)
        {
           if($channel['pid'] == $config['create_channel']['zone'])
           {
               if($channel['channel_topic'] == "wolny")
               {
                   return array("odpowiedz"=>1, "channel_id"=>$channel['cid'],"channel_name"=>$channel['channel_name']);
               }
           }

        }
        return array("odpowiedz"=>0);
    }

    function numer_kanalu($channel_list,$config)
    {
        $licznik = 0;
        foreach ($channel_list as $channel) {
            if ($channel['pid'] == $config['create_channel']['zone']) {
                $licznik++;
            }
        }
        return array("odpowiedz"=>1, "channel_number"=>$licznik);
    }





