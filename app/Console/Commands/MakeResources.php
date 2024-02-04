<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\GenericMakeCommand;

use function Laravel\Prompts\multiselect;

class MakeResources extends GenericMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resources {name} {--domain=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create resource, collection and paginated collection';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $files = multiselect(
            label: 'What files do you want to create?',
            options: [
                'resource' => 'Resource',
                'collection' => 'Collection',
                'paginated_collection' => 'Paginated Collection',
            ]
        );

        foreach ($files as $file) {

            if ($file == 'resource') {
                $this->generateResource();
            } elseif ($file == 'collection') {
                $this->generateCollection();
            } else {
                $this->generatePaginatedCollection();
            }
        }
    }

    private function generateResource(): void
    {
        $path = $this->makeDirectory(
            $this->join('/', ['app/Http/Resources', $this->getDomain()])
        );
        $content = $this->getContent('resource.stub', [
            'class' => $this->getResourceName(),
            'namespace' => $this->getNamespace(),
        ]);
        $file = "{$path}/{$this->getResourceName()}.php";
        $this->makeFile($file, $content);
    }

    private function generateCollection(): void
    {
        $path = $this->makeDirectory(
            $this->join('/', ['app/Http/Resources', $this->getDomain()])
        );
        $content = $this->getContent('resource-collection.stub', [
            'class' => $this->getCollectionName(),
            'namespace' => $this->getNamespace(),
        ]);
        $file = "{$path}/{$this->getCollectionName()}.php";
        $this->makeFile($file, $content);
    }

    private function generatePaginatedCollection(): void
    {
        $path = $this->makeDirectory(
            $this->join('/', ['app/Http/Resources', $this->getDomain()])
        );
        $content = $this->getContent('resource-paginated_collection.stub', [
            'class' => $this->getPaginatedCollectionName(),
            'namespace' => $this->getNamespace(),
        ]);
        $file = "{$path}/{$this->getPaginatedCollectionName()}.php";
        $this->makeFile($file, $content);
    }

    private function getDomain(): string
    {
        $domain = $this->option('domain');

        return $domain ? ucfirst($domain) : '';
    }

    private function getNamespace(): string
    {
        return $this->join('\\', ['App\\Http\\Resources', $this->getDomain()]);
    }

    private function getResourceName(): string
    {
        $name = $this->argument('name');

        return "{$name}Resource";
    }

    private function getCollectionName(): string
    {
        $name = $this->argument('name');

        return "{$name}Collection";
    }

    private function getPaginatedCollectionName(): string
    {
        $name = $this->argument('name');

        return "Paginated{$name}Collection";
    }
}
