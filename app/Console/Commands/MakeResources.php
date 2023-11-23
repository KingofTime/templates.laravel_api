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
    protected $signature = 'make:custom_resources {name} {--domain=}';

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
        $path = $this->makeDirectory("app/Http/Resources{$this->getDomain()}");
        $content = $this->getContent('custom_resources.resource.stub', [
            'RESOURCE_NAME' => $this->getResourceName(),
        ]);
        $file = "{$path}/{$this->getResourceName()}.php";
        $this->makeFile($file, $content);
    }

    private function generateCollection(): void
    {
        $path = $this->makeDirectory("app/Http/Resources{$this->getDomain()}");
        $content = $this->getContent('custom_resources.collection.stub', [
            'COLLECTION_NAME' => $this->getCollectionName(),
        ]);
        $file = "{$path}/{$this->getCollectionName()}.php";
        $this->makeFile($file, $content);
    }

    private function generatePaginatedCollection(): void
    {
        $path = $this->makeDirectory("app/Http/Resources{$this->getDomain()}");
        $content = $this->getContent('custom_resources.paginated_collection.stub', [
            'PAGINATED_COLLECTION_NAME' => $this->getPaginatedCollectionName(),
        ]);
        $file = "{$path}/{$this->getPaginatedCollectionName()}.php";
        $this->makeFile($file, $content);
    }

    private function getDomain(): string
    {
        $domain = $this->option('domain');

        return $domain ? '/'.ucfirst($domain) : '';
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
