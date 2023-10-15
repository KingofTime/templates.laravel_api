<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\GenericMakeCommand;
use Illuminate\Support\Pluralizer;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use function Laravel\Prompts\multiselect;

class MakeRepositories extends GenericMakeCommand
{
    public const EXTRA_FEATURES = [
        'trash' => [
            'trait_name' => 'TrashMethods',
            'test_file' => 'repository.test.feature.trash.stub',
        ],
        'aggregation' => [
            'trait_name' => 'AggregationMethods',
            'test_file' => 'repository.test.feature.aggregation.stub',
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
        $this->generateRepositoryTest($extraFeatures);
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

    /**
     * @param  array<int|string>  $extraFeatures
     */
    private function generateRepositoryTest(array $extraFeatures): void
    {
        $singularModelName = strtolower(Pluralizer::singular($this->getModelName()));
        $pluralModelName = strtolower(Pluralizer::plural($this->getModelName()));

        $tests = $this->getTestsExtraFeatures($extraFeatures, [
            'SINGULAR_MODEL_NAME' => $singularModelName,
            'PLURAL_MODEL_NAME' => $pluralModelName,
        ]);

        $path = $this->makeDirectory('tests/Unit/Repositories');
        $content = $this->getContent('repository.test.stub', [
            'CLASS_NAME' => $this->argument('name'),
            'SEEDER_NAME' => "{$this->getModelName()}Seeder",
            'SINGULAR_MODEL_NAME' => $singularModelName,
            'PLURAL_MODEL_NAME' => $pluralModelName,
            'ADDITIONAL_TESTS' => $tests,
        ]);
        $file = "{$path}/{$this->argument('name')}Test.php";
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

    /**
     * @param  array<int|string>  $extraFeatures
     * @param  array<string>  $variables
     */
    private function getTestsExtraFeatures(array $extraFeatures, array $variables): string
    {
        $tests = '';
        foreach ($extraFeatures as $feature) {
            $file = self::EXTRA_FEATURES[$feature]['test_file'];

            $contents = file_get_contents(__DIR__."/../../../stubs/{$file}");

            if ($contents) {
                $tests .= $contents;
                $tests .= "\n";
            } else {
                throw new FileException("Fail of Read Stub {$file}");
            }
        }

        foreach ($variables as $search => $replace) {
            $tests = str_replace('$'.$search.'$', $replace, $tests);
        }

        return $tests;
    }
}
