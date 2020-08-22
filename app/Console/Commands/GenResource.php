<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:a-crud 
        {resource : the resource name, used with UpperCamelCases.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate resource crud files';

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
        $camelResource = $this->argument('resource');
        $snakeResouceWithLowDash = Str::snake($camelResource);
        $snakeResouceWithDash = Str::snake($camelResource, '-');
        $singularResource = Str::singular($camelResource);

        $this->info('Start to create controller.');
        \Artisan::call("make:controller Admin\\\\{$camelResource}Controller");
        $this->info('Start to create model.');
        \Artisan::call("make:model Model\\\\{$singularResource}");
        $this->info('Start to create migration.');
        \Artisan::call("make:migration create_{$snakeResouceWithLowDash}_table --table");
        $this->info('Start to create crud views.');
        \Artisan::call("make:view admin.{$snakeResouceWithDash}._form");
        \Artisan::call("make:view admin.{$snakeResouceWithDash} --resource --verb=index --verb=create --verb=edit");

        $templates = ['create', 'edit', 'index', '_form'];
        foreach ($templates as $_stub) {
            $path = resource_path("views/vendor/admin-template-stub/{$_stub}.stub.blade.php");
            $stubFile = fopen($path, "r");
            $stubSize = filesize($path);
            $stubContent = $stubSize > 0 ? fread($stubFile, $stubSize) : '';
            fclose($stubFile);

            $target = resource_path("views/admin/{$snakeResouceWithDash}/{$_stub}.blade.php");
            $targetFile = fopen($target, 'w+');
            fwrite($targetFile, $stubContent);
            fclose($targetFile);
        }
    }
}
