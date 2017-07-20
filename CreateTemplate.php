<?php

namespace App\Console\Commands;

use Storage;
use File;
use League\Flysystem\Filesystem;
use Illuminate\Console\Command;

class CreateTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:new {name} {--dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea los directorios basicos del template';

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
      $name = $this->argument('name');
      $slug = str_slug($name);
      $publicPath = public_path('templates');
      $templatePath = resource_path('views');
      $this->info("Preparando carpetas para el template $name\n");


      $directories = [
        $publicPath,
        $publicPath.'/'.$slug,
        $publicPath.'/'.$slug.'/assets',
        $publicPath.'/'.$slug.'/assets/css',
        $publicPath.'/'.$slug.'/assets/img',
        $publicPath.'/'.$slug.'/assets/js',
        $templatePath.'/templates',
        $templatePath.'/templates/'.$slug,
      ];

      $files = [
        $publicPath.'/'.$slug.'/assets/css'.'/main.css',
        $publicPath.'/'.$slug.'/assets/js'.'/main.js',
        $templatePath.'/templates/'.$slug.'/index.blade.php',
      ];


      foreach ($directories as $dir) {
        if (File::makeDirectory("$dir", 0775, true, true)) {
          $this->info($dir);
        }else{
          $this->line('Error al crear el directorio, ya existe?');
          $this->line($dir);
        }
      }
      $this->info("\nPreparando archivos base para el template $name\n");
      foreach ($files as $file) {
        // $this->info($file);
        if (File::put("$file", ' ')) {
          $this->info($file);
        }else{
          $this->error('Error al crear el archivo');
          $this->error($file);
        }
      }


      /**
       * Development only!
       */
       if ($this->option('dev')) {
         $this->error("\nEliminando directorios creados");
         foreach ($directories as $dir) {
           if (File::deleteDirectory($dir)) {
             $this->error('Eliminado --> '.$dir);
           }else{
             $this->error('Eliminado --> '.$dir);
           }
         }
         $this->error("\n\nBOOM!");
       }
    }
}
