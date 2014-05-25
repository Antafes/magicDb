<?php
require_once(__DIR__.'/../lib/config.default.php');
require_once(__DIR__.'/../lib/util/mysql.php');

$translator = \Translator::getInstance();
$translator->addTranslation(1, $_GET['typeKey'], $_GET['typeNameDe']);
$translator->addTranslation(2, $_GET['typeKey'], $_GET['typeNameEn']);
$type = \Model\Type::create($_GET['typeKey'], $_GET['parent']);

$response = array(
	'typeId'   => $type->getTypeId(),
	'language' => $translator->getCurrentLanguage(),
);

if (!$_GET['parent'])
{
	$response['key'] = $type->getName();
}

echo json_encode($response);