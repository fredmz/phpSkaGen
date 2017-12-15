<?php
require_once (__DIR__.'/../vendor/autoload.php');
use Fredmz\Generator\Generator;
const ROOT_DIR = 'C:\Users\FRED\dev\php\gen';
const MODEL_DIR = ROOT_DIR.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'model';
const GEN_DIR = ROOT_DIR.DIRECTORY_SEPARATOR.'generated';
$gen = new Generator(MODEL_DIR, 'ubicacion.Pais', GEN_DIR);
d($gen);
$gen->createBackend();