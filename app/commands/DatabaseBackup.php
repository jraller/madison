<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DatabaseBackup extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:backup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Backs up the current database with timestamp.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$total_backups = 10;
		$backups_path = storage_path() . '/db_backups';

		$this->setup($backups_path);
		$this->backup($backups_path);
		$this->cleanup($backups_path, $total_backups);
	}

	//Create backups directory if it doesn't exist
	public function setup($backups_path){
		if(!file_exists($backups_path)){
			//$this->info('Backups directory doesn\nt exist.  Creating...');
			mkdir($backups_path);
		}
	}

	//Run mysqldump and include timestamp in file name
	public function backup($backups_path){
		$creds = yaml_parse_file(app_path() . '/config/creds.yml');
		$timestamp = date('c', strtotime('now'));
		$filename = $timestamp . '_bak.sql';

		exec('mysqldump ' . $creds['database'] . ' -u' . $creds['username'] . ' -p' . $creds['password'] . ' > ' . $backups_path . '/' . $filename);

		$this->info("Backup created.");
	}

	//Limit number of saved backups
	public function cleanup($backups_path, $total_backups){
		$files = glob($backups_path . '/*.sql');

		usort($files, function ($a, $b) {
			$timestamp_a = $this->getTimestamp($a);
			$timestamp_b = $this->getTimestamp($b);

			$this->info($timestamp_a . " < " . $timestamp_b);

			return $timestamp_a < $timestamp_b;

		});

		$i = 0;

		foreach($files as $file){

			if($i >= $total_backups){
				$this->info('Removing ' . $file);
				unlink($file);
			}else{
				$this->info('Keeping ' . $file);
			}

			$i++;
		}
	}

	public function getTimestamp($filename){
		$file = basename($filename);

		$timestamp = explode('_', $file);
		$timestamp = $timestamp[0];

		return $timestamp;
	}
}
