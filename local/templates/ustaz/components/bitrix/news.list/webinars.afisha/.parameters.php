<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


$arTemplateParameters = [
    "IS_AUTHORIZED" => [
        "NAME" => "Авторизован ли пользователь?",
        "TYPE" => "STRING",
        "VALUE" => '={$GLOBALS["USER"]->IsAuthorized()}',
        "DEFAULT" => '={$GLOBALS["USER"]->IsAuthorized()}',
    ],
];