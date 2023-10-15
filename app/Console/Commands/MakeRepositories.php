<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\GenericMakeCommand;

use function Laravel\Prompts\multiselect;

class MakeRepositories extends GenericMakeCommand
{
    public const EXTRA_FEATURES = [
        'trash' => [
            'trait_name' => 'TrashMethods',
        ],
        'aggregation' => [
            'trait_name' => 'AggregationMethods',
        ],
    ];

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
    public function handle(): void
    {
        $extraFeatures = multiselect(
            label: 'Do you want to add any extra modules?',
            options: [
                'trash' => 'Trash Features',
                'aggregation' => 'Aggregation Features',
            ]
        );

        $this->generateRepository($extraFeatures);
    }

    /**
     * @param  array<int|string>  $extraFeatures
     */
    private function generateRepository(array $extraFeatures): void
    {
        $traits = $this->getContentExtraFeatures($extraFeatures);
        $path = $this->makeDirectory('app/Repositories');
        $content = $this->getContent('repository.stub', [
            'CLASS_NAME' => $this->argument('name'),
            'MODEL_NAME' => $this->getModelName(),
            'IMPORT_TRAITS' => $traits['imports'],
            'USE_TRAITS' => $traits['uses'],
        ]);
        $file = "{$path}/{$this->argument('name')}.php";
        $this->makeFile($file, $content);
    }

    private function getModelName(): string
    {
        return str_replace('Repository', '', $this->argument('name'));
    }

    /**
     * @param  array<int|string>  $extraFeatures
     * @return string[]
     */
    private function getContentExtraFeatures(array $extraFeatures): array
    {
        $imports = '';
        $uses = '';
        foreach ($extraFeatures as $feature) {
            $trait = self::EXTRA_FEATURES[$feature]['trait_name'];

            $imports .= "use App\Repositories\Base\Traits\\{$trait};\n";
            $uses .= "use {$trait};\n\t";
        }

        return [
            'imports' => $imports,
            'uses' => $uses,
        ];
    }
}
