<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PushGit extends Command
{
    protected $signature = 'mti:push';
    protected $description = 'Push Project to Git';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {

            $this->info(" [MCFLYON] => Mempersiapkan...");

            $txt = $this->ask("[MCFLYON] => Komentar Commit? ");
            $this->info(" [MCFLYON] => Memulai...");

            $cmd = ["git add .", "git commit -m \"{$txt}\"", "git push"];
            $bar = $this->output->createProgressBar(count($cmd));
            $bar->start();

            foreach ($cmd as $key => $value) {
                $add = new Process($value);
                $add->mustRun();
                $bar->advance();
                if($key == (count($cmd)-1)){
                    $bar->finish();
                    $this->info(" Done");
                }
            }
            $this->info(" [MCFLYON] => Berhasil Push Git [{$txt}]");
            $this->info("");
        } catch (ProcessFailedException $e) {
            $this->error('Push Git Error!');
            $this->error($e);
            
        }
    }
}
