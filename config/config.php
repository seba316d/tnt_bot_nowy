<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-05-09
 * Time: 19:26
 */

$teamspeak['address'] = '127.0.0.1';
$teamspeak['udp'] = '9987';
$teamspeak['tcp'] = '10011';
$teamspeak['login'] = 'serveradmin';
$teamspeak['password'] = 'wNMRvyio';

$config['bot']['name'] = "Frodo BOT";
$config['bot']['default_channel'] = 2; // kanal na jakim siedzi bot

$config['afk']['channel'] = 5;//Kanal jaki jest jako AFK

//POKE
$config['poke']['channel'] = 4; // Kanal na ktory wchodzi uzytkownik i jest poke
$config['poke']['group'] = array(6,7); // grupy które mają byc pokowane
$config['poke']['interval'] = 0; // na razie nie dziala

//Tworzenie kanałów
$config['create_channel']['zone'] = 13; // W jakiej strefie tworzy kanały
$config['create_channel']['sub-channel_create'] = true; // Czy tworzyc podkanaly true - TAK lub false - NIE
$config['create_channel']['sub-channel'] = 1; //Liczba podkanałów do utworzenia
$config['create_channel']['channel'] = 6; //id kanału na z ktorego maja byc tworzone kanały
$config['create_channel']['channel_group'] = 5; //Id rangi kanałowej ktora ma byc nadawana przy tworzeniu kanału