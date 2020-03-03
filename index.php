<?php
declare(strict_types = 1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'vendor/autoload.php';

use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\NativeMailerHandler;


// create a log channel
$logBlue = new Logger('blue');
$logYellow = new Logger('yellow');
$logRed = new Logger('red');
$logBlack = new Logger('black');


$logBlue->pushHandler(new StreamHandler(__DIR__ . '/logs/blue.log', Logger::DEBUG));
$logYellow->pushHandler(new StreamHandler(__DIR__ . '/logs/yellow.log', Logger::WARNING));
$logRed->pushHandler(new StreamHandler(__DIR__ . '/logs/red.log', Logger::ERROR));
$logBlack->pushHandler(new StreamHandler(__DIR__ . '/logs/blue.log', Logger::EMERGENCY));

// blue
if(isset($_GET['DEBUG']) ){
    $message = $_GET['message'];
    $logBlue->debug('DEBUG (100): Detailed debug information' . $message);
}

if(isset($_GET['INFO'])){
    $message = $_GET['message'];
    $logBlue->pushHandler(new BrowserConsoleHandler());
    $logBlue->info('INFO (200): Interesting events. Examples: User logs in, SQL logs. ' . $message);
}

if(isset($_GET['NOTICE'])){
    $message = $_GET['message'];
    $logBlue->notice('NOTICE (250): Normal but significant events.' . $message);
}

//yellow
if(isset($_GET['WARNING'])){
    $message = $_GET['message'];
    $logYellow->warning('WARNING (300): Exceptional occurrences that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong ' . $message);
}

//red
if(isset($_GET['ERROR'])){
    $message = $_GET['message'];
    $logRed->error('ERROR (400): Runtime errors that do not require immediate action but should typically be logged and monitored.' . $message);
    $logRed->pushHandler(new NativeMailerHandler('sali@.com' , (string)$_GET['message'] ,'me@me.dev', LOGGER::ERROR));

}

if(isset($_GET['CRITICAL'])){
    $message = $_GET['message'];
    $logRed->critical('CRITICAL (500): Critical conditions. Example: Application component unavailable, unexpected exception.' . $message);
}

if(isset($_GET['ALERT'])){
    $message = $_GET['message'];
    $logRed->alert('ALERT (550): Action must be taken immediately. Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.' . $message);
}

//Black
if(isset($_GET['EMERGENCY'])){
    $message = $_GET['message'];
    $logBlack->pushHandler(new BrowserConsoleHandler());
    $logBlack->alert('EMERGENCY (600): Emergency: system is unusable.' . $message);
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logger</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
</head>
<body>
<form method="get">
    <h1>Using Monolog with Composer</h1>

    <input type="text" name="message" placeholder="My log message" class="form-control" required/>

    <button type="submit" name="DEBUG" value="DEBUG"  class="btn btn-info">DEBUG (100): Detailed debug information.
    </button>
    <button type="submit" name="INFO" value="INFO" class="btn btn-info">INFO (200): Interesting events. Examples: User
        logs in, SQL logs.
    </button>
    <button type="submit" name="NOTICE" value="NOTICE" class="btn btn-info">NOTICE (250): Normal but significant events.
    </button>
    <button type="submit" name="WARNING" value="WARNING" class="btn btn-warning">WARNING (300): Exceptional occurrences
        that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not
        necessarily wrong.
    </button>
    <button type="submit" name="ERROR" value="ERROR" class="btn btn-danger">ERROR (400): Runtime errors that do not
        require immediate action but should typically be logged and monitored.
    </button>
    <button type="submit" name="CRITICAL" value="CRITICAL" class="btn btn-danger">CRITICAL (500): Critical conditions.
        Example: Application component unavailable, unexpected exception.
    </button>
    <button type="submit" name="ALERT" value="ALERT" class="btn btn-danger">ALERT (550): Action must be taken
        immediately. Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and
        wake you up.
    </button>
    <button type="submit" name="type" value="EMERGENCY" class="btn btn-dark">EMERGENCY (600): Emergency: system is
        unusable.
    </button>
</form>

<style>
    button {
        display: block;
        margin: 12px 0px;
    }
</style>


</body>
</html>
