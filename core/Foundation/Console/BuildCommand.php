<?php

namespace Core\Foundation\Console;

use Illuminate\Console\Command;
use File;
use Schema;
use DB;

class BuildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:build {--quick}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Easy build up application.';

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
        $quick = $this->option('quick');
        if (! $quick) {
            $this->updateComposer();
        }

//        $this->publishVendor();
//        $this->refreshDatabase();
//        $this->flushStorages();
        $this->optimize();
    }

    protected function flushStorages()
    {
        File::cleanDirectory(config('filesystems.disks.local.root'));
        $this->info('Local storage flushed!');
        $this->call('cache:clear');
        $this->call('view:clear');
    }

    protected function optimize()
    {
        $this->call('optimize');
    }

    protected function refreshDatabase()
    {
        try {
            $this->dropDatabase();
            $this->call('migrate');
            $this->call('db:seed');
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage() . "\n" . 'Please check your database connection configuration at .env file');
        }
    }

    protected function publishVendor()
    {
        $this->call('vendor:publish');
        $this->call('vendor:publish', ['--tag' => ['lang'], '--force' => true]);
        $this->call('vendor:publish', ['--tag' => ['migrations'], '--force' => true]);
    }

    protected function updateComposer()
    {
        if (is_callable('shell_exec') && false === stripos(ini_get('disable_functions'), 'shell_exec')) {
            return shell_exec('composer update --optimize-autoloader');
        }

        $this->warn('"shell_exec" function is disabled in this environment, you should execute "composer update" before use this command.');
        $this->line('');
    }

    protected function dropDatabase()
    {
        $tables = [];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach (DB::select('SHOW TABLES') as $k => $v) {
            $tables[] = array_values((array)$v)[0];
        }

        foreach($tables as $table) {
            Schema::drop($table);
            $this->info('Drop table: ' . $table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
