<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDatabase extends Command
{
    protected $signature = 'mti:db:backup';
    protected $description = 'Backup Database';
    protected $process;

    public function __construct()
    {
        parent::__construct();

        $today = today()->format('Y-m-d');
        if(!is_dir(storage_path('backups'))) mkdir(storage_path('backups'));

        $this->process = new Process(sprintf(
            'mysqldump --compact --skip-comments -u %s -p %s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            storage_path("backups/{$today}_".config('database.connections.mysql.database').".sql")
        ));

    }

    public function handle()
    {
        try {
            $this->info("[MCFLYON] => Mempersiapkan...");
            $this->info("[MCFLYON] => Membackup Database...");
            $this->process->mustRun();
            $this->info('[MCFLYON] => Success Backup Database ['.config('database.connections.mysql.database').']');
        } catch (ProcessFailedException $e) {
            $this->error('Backup Database Error!');
            
        }
    }
}
