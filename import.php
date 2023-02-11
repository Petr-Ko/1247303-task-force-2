<?php

use TaskForce\classes\db\ImportCsv;

require_once 'vendor/autoload.php';

$import_categories = new ImportCsv('data\categories.csv');

$import_categories->SetDataInDb('categories');

$import_city = new ImportCsv('data\cities.csv');

$import_city->SetDataInDb('cities');