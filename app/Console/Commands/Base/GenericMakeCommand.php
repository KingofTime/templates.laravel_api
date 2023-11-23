<?php

namespace App\Console\Commands\Base;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

abstract class GenericMakeCommand extends Command
{
    public function __construct(
        protected Filesystem $files
    ) {
        parent::__construct();
    }

    protected function makeDirectory(string $folder): string
    {
        $path = base_path($folder);
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * @param  array<string, string>  $variables
     *
     * @throws FileException
     */
    protected function getContent(string $stub, array $variables): string
    {
        $contents = file_get_contents(__DIR__."/../../../../stubs/{$stub}");

        if ($contents) {
            foreach ($variables as $search => $replace) {
                $contents = str_replace('{{ '.$search.' }}', $replace, $contents);
            }

            return $contents;
        }
        throw new FileException("Fail of Read Stub {$stub}");
    }

    protected function makeFile(string $path, string $content): void
    {
        if (! $this->files->exists($path)) {
            $this->files->put($path, $content);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    /**
     * @param  array<string>  $values
     */
    protected function join(string $separator, array $values): string
    {
        return trim(implode($separator, $values), $separator);
    }
}
