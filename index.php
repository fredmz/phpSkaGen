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
        <style>
            body {background-color: #9192a0;}
            .code {
                white-space: pre;
                font-size: 0.9em;
                font-family: "Courier New";
                padding: 5px;
                border: 1px solid #456454;
                background-color: #fffff2;
                color: #3e3a52;
                margin: 5px;
                max-width: 600px;
                min-height: 150px;
                overflow-x: auto;
                overflow-y: auto;
            }
        </style>
    </head>
    <body>
<?php 
    $gen = new Generator(MODEL_DIR, 'ubicacion.Pais', GEN_DIR);
    d($gen);
    $gen->createBackend();
?>
    </body>
</html>