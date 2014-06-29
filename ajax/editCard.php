<?php
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

$translator = Translator::getInstance();

if (!$_GET['id'] || !$_GET['nameDe']['value'] || !$_GET['nameEn']['value'] || !$_GET['type']['value']
	|| !$_GET['rarity']['value'] || !$_GET['color']['value'] || !isset($_GET['amount']['value'])
	|| !is_numeric($_GET['amount']['value']) || !isset($_GET['foiled']['value'])
	|| !is_numeric($_GET['foiled']['value']))
{
	die();
}

$preparedTypes = array();
foreach (explode('-', $_GET['type']['value']) as $key => $type)
{
	$preparedTypes[] = array(
		'id'      => $type,
		'sorting' => $key,
	);
}

$card = new \Model\Card();
$card->loadByCardId($_GET['id']);
$card->update(
	$_GET['nameDe']['value'], $_GET['nameEn']['value'], $preparedTypes, $_GET['color']['value'],
	$_GET['rarity']['value'], $_GET['amount']['value'], $_GET['foiled']['value']
);
echo json_encode(array('ok' => true));