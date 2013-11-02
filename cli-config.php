<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$entityManager = include( "bootstrap.php" );

return ConsoleRunner::createHelperSet($entityManager);