<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeVueView extends Command
{
    protected $signature = 'make:vue {file : Lokasi view yang akan dibuat}';

    protected $description = 'Untuk membuat view dengan php artisan';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        if(is_file(app_path().'/../resources/assets/js/pages/'.$this->argument('file').'.vue')){
            return $this->error("[MCFLYON] => File sudah ada!");
        }
        $this->info("[MCFLYON] => Membuat Vue JS File ...");

        $template = $this->ask('[MCFLYON] => Menggunakan Template (Metronic) [y/n]? ', 'No');

        if (strtolower($template) == 'y'){
            $script = "<template>
    <div class=\"container\">
        <div class=\"card card-custom\">
            <div class=\"card-header\">
                <div class=\"card-title\">
                    <span class=\"card-icon\">
                        <i class=\"flaticon-black text-primary\"></i>
                    </span>
                    <h3 class=\"card-label\">
                        MCFLYON
                    </h3>
                </div>
            </div>
            <div class=\"card-body\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <h3>AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND</h3>
                        <div style=\"display: block;\">
                            <div class=\"mcflyon\">MCFLYON</div><div class=\"system\">System, Apps & Website Development</div>
                        </div>
                        <div class=\"sysfly\">This System Development by Mcflyon Teknologi Indonesia visit</div><div class=\"at\">@</div><a href=\"https://www.mcflyon.co.id\" class=\"url\">https://www.mcflyon.co.id</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .mcflyon {
        display:inline;
        width:200px;
        border-radius: 3px 0 0 3px;
        padding:3px 15px;
        background:#108bc3;
        color:#FFF;
        font-size: 30px;
        font-family:Arial, Helvetica, sans-serif;
        font-weight: bold;
    }
   .system {
        display:inline;
        border-radius: 0 3px 3px 0;
        padding:3px 15px;
        background:#f2f3f8;
        color:#666;
        font-size: 30px;
        font-family:Arial, Helvetica, sans-serif;
    }
    .sysfly {
        display: inline;
        border-radius: 3px 0 0 3px;
        padding:3px 65px 3px 10px;
        background:#35495e;
        color:#fff;
        font-size: 12px;
        font-weight: bold;
    }
    .at {
        display: inline;
        border-radius:0px;
        padding:3px 50px;
        background:#35495e;
        color:#FF5722;
        padding-left:0px;
        font-size: 12px;
        font-weight: bold;
    }
    .url {
        display: inline;
        border-radius: 0 3px 3px 0;
        padding:3px 15px;
        background:#35495e;
        color:#fff;
        font-size: 12px;
        font-weight: bold;
    }
    .url:hover {
        color: #0f8ac3;
    }
</style>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

    export default {
        data() {
            return {
                
            }
        },
        methods: {

        },
        mounted() {
            
        }
    }
</script>";
        }else{
            $script = "<template>
</template>

<script>

    // AUTO GENERATE VUE FILE BY MCFLYON ARTISAN COMMAND

    export default {
        data() {
            return {
                
            }
        },
        methods: {

        },
        mounted() {
            
        }
    }
</script>";

        }


        $path = explode('/', app_path().'/../resources/assets/js/pages/'.$this->argument('file').'.vue');

        array_pop($path);

        $path = implode('/', $path);

        $filename = app_path().'/../resources/assets/js/pages/'.$this->argument('file').'.vue';

        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        file_put_contents($filename, $script);

        return $this->info("[MCFLYON] => Berhasil!");
    }
}