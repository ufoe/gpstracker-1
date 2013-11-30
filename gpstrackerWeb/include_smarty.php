<?php


// put full path to Smarty.class.php
require('Smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('smartyFra/templates');
$smarty->setCompileDir('smartyFra/templates_c');
$smarty->setCacheDir('smartyFra/cache');
$smarty->setPluginsDir(array('smartyFra/plugins','Smarty/plugins'));
$smarty->setConfigDir('smartyFra/configs');

include 'classi/Config.php';
$smarty->assign("configs",  Config::getConfigs());

$c=array();
foreach (Config::getConfigs() as $config_) {
    $c[$config_->con_cod]=$config_->con_val;
}
$smarty->assign("config",  $c);

$smarty->assign("admin", false);

if (getGet("cache",1)==1) {
    $smarty->caching = true;
} else {
    $smarty->clearAllCache();
    $smarty->caching = false;
}
