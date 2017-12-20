<?php
session_start();
require_once (__DIR__.'/vendor/autoload.php');
use Fredmz\Generator\Generator;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$ROOT_DIR = $_SESSION['root_dir']??($_POST['root_dir']??NULL);
$PROJECT_PACKAGE = $_SESSION['projectPackage']??($_POST['projectPackage']??NULL);

if ($ROOT_DIR != NULL) {
    $_SESSION['root_dir'] = $ROOT_DIR;
    if ($PROJECT_PACKAGE != null) {
        $_SESSION['projectPackage'] = $PROJECT_PACKAGE;
        //const ROOT_DIR = 'C:\Users\FRED\dev\php\gen';
        //$ROOT_DIR = 'E:\desarrollo\php\phpSkaGen';
        $MODEL_DIR = $ROOT_DIR . DIRECTORY_SEPARATOR . '.skagen';
        $GEN_DIR = $ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'main';
        d($GEN_DIR);
//        $PROJECT_PACKAGE = 'pe.org.institutoapoyo.sig';
    }
}
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
            input[type="text"] {width: 350px;}
        </style>
        <script src="static/prism.js"></script>
    </head>
    <body>
    <form action="" method="post">
        <table>
            <tr>
                <td>Project directory</td>
                <td><input type="text" name="root_dir" placeholder="Put the root directory of your project" value="<?php echo $ROOT_DIR;?>"></td>
            </tr>
            <tr>
                <td>Project package</td>
                <td><input type="text" name="projectPackage" placeholder="Put the root project package" value="<?php echo $PROJECT_PACKAGE;?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="cargar">
                </td>
            </tr>
        </table>
    </form>
<?php
    if ($PROJECT_PACKAGE != NULL) {
        $gen = new Generator($MODEL_DIR, 'ubicacion.Pais', $PROJECT_PACKAGE, $GEN_DIR);
//        $gen->createBackend();
        $gen->getFrontendGenerator()->getModelGenerator()->createClass();
        $gen->getFrontendGenerator()->getServiceGenerator()->createClass();
    }?>
    </body>
</html>