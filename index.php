<?php
require __DIR__ . '/autoload.php';

$router = Router::createRouteTable([
        '/tags'             => 'Tag.all', 
        '/tags/(\d+)'       => 'Tag.one',
        '/tags/find'        => 'Tag.find', 
        '/tags/add'         => 'Tag.add',
        '/tags/(\d+)/edit'  => 'Tag.edit',
        '/tags/(\d+)/delete'=> 'Tag.delete',
        '/images'           => 'Image.all',
        '/images/(\d+)'     => 'Image.one'
    ]);


$router->setDefault('Tag.def1');
$router->start();
View::currentView()->showPage();
