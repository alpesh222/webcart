<?php

namespace App\Console\Commands;

use DB;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webcart:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Webcart.';

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
    public function handle()
    {
        $php_version = '7.0.0';

        if (version_compare(PHP_VERSION, $php_version) >= 0) {
            $this->comment('PHP version '.PHP_VERSION. ' - OK');
        } else {
            $this->error('PHP Version must be greater than or equal to '.$php_version);
            return;
        }

        if (extension_loaded('openssl')) {
            $this->comment('OpenSSL enabled - OK');
        } else {
            $this->error('OpenSSL is not enabled.');
            return;
        }

        $permission = '0777';

        $this->chmod_r(storage_path('framework'), $permission);
        $this->chmod_r(storage_path('logs'), $permission);
        $this->chmod_r(base_path('bootstrap'.DIRECTORY_SEPARATOR.'cache'), $permission);
        $this->chmod_r(public_path('img'), $permission);
		$this->chmod_r(public_path('css'.DIRECTORY_SEPARATOR.'custom'), $permission);
        $this->chmod_r(config_path(), $permission);

        $this->comment('Permissions verified.');

        try {
            DB::connection();
        } catch (Exception $e) {
            $this->error('Unable to connect to database.');
            $this->error('Please fill valid database credentials into .env and rerun this command.');
            return;
        }

        while(true) {
            $email = $this->ask('Provide email for Super Admin > ');

	        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	            $this->error('Invalid email.');
	            continue;
	        }

	        $username = $this->ask('Provide username for Super Admin > ');

            $password = $this->secret('Provide password for Super Admin > ');
            $password_confirm = $this->secret('Confirm password for Super Admin > ');

            if($password !== $password_confirm) {
	            $this->error('Password did not match. Try again.');
	            continue;
            }

            $this->comment('Email   : '.$email);
            $this->comment('Username: '.$username);
            if($this->confirm('Do you wish to continue?')) {
                break;
            }
        }

        $this->comment('Attempting to install Webcart - 1.0.0');

        if (!env('APP_KEY')) {
            $this->info('Generating app key');
            Artisan::call('key:generate');
        } else {
            $this->comment('App key exists -- skipping...');
        }

        $this->info('Migrating database... please wait....');

        Artisan::call('migrate', ['--force' => true]);

        DB::table('users')->where('id', 1)->update(['email' => $email, 'username' => $username, 'password' => bcrypt($password), 'verified' => true]);

        $this->comment('Database Migrated Successfully.');

        $this->info('Seeding DB data... please wait....');

        Artisan::call('db:seed', ['--force' => true]);

        $this->comment('Database Seeded Successfully.');

        $this->comment('Successfully Installed!');
    }

    private function chmod_r($dir, $permission)
    {
        $dp = opendir($dir);

        while($file = readdir($dp))
        {
            if (($file == ".") || ($file == "..")) continue;

            $path = $dir . DIRECTORY_SEPARATOR . $file;
            $is_dir = is_dir($path);

            $this->set_perms($path, $is_dir, $permission);
            if($is_dir) {
                $this->chmod_r($path, $permission);
            }
        }
        closedir($dp);
    }

    private function set_perms($file, $is_dir, $permission)
    {
        $perm = substr(sprintf("%o", fileperms($file)), -4);
        $dirPermissions = $permission;
        $filePermissions = $permission;

        if($is_dir && $perm != $dirPermissions)
        {
            chmod($file, octdec($dirPermissions));
        }
        else if(!$is_dir && $perm != $filePermissions)
        {
            chmod($file, octdec($filePermissions));
        }

        flush();
    }
}