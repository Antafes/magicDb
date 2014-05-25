<?php
require_once(__DIR__.'/lib/config.default.php');
require_once(__DIR__.'/lib/util/mysql.php');

session_start();

$display = new \Display();

$page = $_GET['page'];

if (!$page)
	$page = 'Index';

if ($_GET['language'])
{
	$translator = \Translator::getInstance();
	$translator->setCurrentLanguage($_GET['language']);

	redirect('index.php?page='.$page);
}

$display->showPage($page);