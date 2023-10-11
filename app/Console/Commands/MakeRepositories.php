<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\GenericMakeCommand;
use function Laravel\Prompts\multiselect;

class MakeRepositories extends GenericMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $traits = multiselect('Do you want to add any extra traits?',
        ['TrashMethods', 'AggregationMethods']);

        $path = $this->makeDirectory('Repositories');
        $content = $this->getContent('repository.stub', [
            'NAMESPACE' => 'App\Repositories',
            'CLASS_NAME' => $this->argument('name'),
            'MODEL_NAME' => $this->getModel(),
            'IMPORT_TRAITS' => $this->getImportTraits($traits),
            'USE_TRAITS' => $this->getUseTraits($traits)
        ]);
        $file = "{$path}/{$this->argument('name')}.php";
        $this->makeFile($file, $content);
    }

    private function getModel(): string
    {
        return str_replace('Repository', '', $this->argument('name'));
    }

    private function getUseTraits(array $traits): string
    {
        $content = "";
        foreach ($traits as $trait)
        {
            $content .= "use {$trait};\n\t";
        }

        return $content;
    }

    private function getImportTraits(array $traits): string
    {
        $content = "";
        foreach ($traits as $trait)
        {
            $content .= "use App\Repositories\Base\Traits\\{$trait};\n";
        }

        return $content;
    }

}
