<?php
date_default_timezone_set('Asia/Jakarta');

require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Yaml\Yaml;

if( isset($_POST['payload']) )
{
	$config = Yaml::parse(file_get_contents('config.yml'));
	$payload = json_decode($_POST['payload']);

	$LOCAL_REPO = $_SERVER['DOCUMENT_ROOT'] . "/" . $payload->repository->slug;
	$REMOTE_SSH_REPO = "git@bitbucket.org:" . $payload->user . "/" . $payload->repository->slug . ".git";

	$shell_error = "";
	if (file_exists($LOCAL_REPO)) {
	    $shell_error = shell_exec("cd " . $LOCAL_REPO . " && git pull");
	} else {
	    $shell_error = shell_exec("cd " . $_SERVER['DOCUMENT_ROOT'] . " && git clone " . $REMOTE_SSH_REPO );
	}

	// get log message
	$log_message = $payload->commits[0]->timestamp . " " . $payload->commits[0]->node . " " . $payload->commits[0]->message;

	$log = new Logger('UPDATES');
	if( strlen($shell_error) == 0 )
	{
		$log->pushHandler(new StreamHandler('logs/' . $payload->repository->slug . '.log', Logger::INFO));
		$log->addInfo( $log_message );
	}
	else
	{
		$log->pushHandler(new StreamHandler('logs/' . $payload->repository->slug . '.log', Logger::ERROR));
		$log->addInfo( $shell_error );
	}

	echo json_encode($log_message);
}