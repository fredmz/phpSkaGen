<?php
require_once (__DIR__.'/vendor/autoload.php');
use Fredmz\Generator\Generator;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

//const ROOT_DIR = 'C:\Users\FRED\dev\php\gen';
const ROOT_DIR = 'E:\desarrollo\php\phpSkaGen';
const MODEL_DIR = ROOT_DIR.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'model';
const GEN_DIR = ROOT_DIR.DIRECTORY_SEPARATOR.'generated';
?>
<html>
    <head>
        <title>Generator</title>
        <link rel="stylesheet" type="text/css" href="static/prism.css">
        <style>
            body {background-color: #9192a0;}
            pre {
                font-size:12px;
                max-width: 600px;
                max-height: 300px;
                overflow: auto;
            }
        </style>
        <script src="static/prism.js"></script>
    </head>
    <body>
<?php 
    $gen = new Generator(MODEL_DIR, 'ubicacion.Pais', GEN_DIR);
    d($gen);
    $gen->createBackend();
?>
    </body>
</html>