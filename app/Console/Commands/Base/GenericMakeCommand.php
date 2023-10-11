<?php

namespace App\Console\Commands\Base;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

abstract class GenericMakeCommand extends Command
{
    public function __construct(
        protected Filesystem $files
    ){
        parent::__construct();
    }

    protected function makeDirectory(string $folder): string
    {
        $path = app_path($folder);
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    protected function getContent(string $stub, $variables)
    {
        $contents = file_get_contents(__DIR__. "/../../../../stubs/{$stub}");

        foreach ($variables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    protected function makeFile(string $path, string $content): void
    {
        if (!$this->files->exists($path)) {
            $this->files->put($path, $content);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

}
