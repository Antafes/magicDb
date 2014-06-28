<?php
$translator = Translator::getInstance();

if (!$_GET['id'] || !$_GET['nameDe'] || !$_GET['nameEn'] || !$_GET['type'] || !$_GET['rarity']
	|| !$_GET['color'] || !isset($_GET['amount']) || !is_numeric($_GET['amount'])
	|| !isset($_GET['foiled']) || !is_numeric($_GET['foiled']))
{
	die();
}

$preparedTypes = array();
foreach (explode('-', $types) as $key => $type)
{
	$preparedTypes[] = array(
		'id'      => $_GET['type'],
		'sorting' => $key,
	);
}

$card = new \Model\Card();
$card->loadByCardId($_GET['id']);
$card->update(
	$_GET['nameDe'], $_GET['nameEn'], $_GET['type'], $_GET['color'], $_GET['rarity'],
	$_GET['amount'], $_GET['foiled']
);
echo json_encode(array('ok' => true));