<?php

use Core\Controller\SaleControl;

/* This just sets up everything that needs setuping... */
require_once('config/configuration.php');

/* ...and this fires the report generator */
$control = new SaleControl();
$control->generateReport();

?>