<?php
/**
 * @file load.captcha.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

session_start();
$captcha = new KCAPTCHA();
$_SESSION['Var_session'] = $captcha->getKeyString();
