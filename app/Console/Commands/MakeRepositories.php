<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\GenericMakeCommand;

use function Laravel\Prompts\multiselect;

class MakeRepositories extends GenericMakeCommand
{
    private const FEATURES = [
        'crud' => [
            'name' => 'CRUDMethods',
            'dependencies' => ['get_model'],
            'interface' => 'CRUDInterface',
        ],
        'trash' => [
            'name' => 'TrashMethods',
            'dependencies' => ['get_model'],
            'interface' => 'TrashInterface',
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
        $features = multiselect(
            label: 'Do you want to add any extra modules?',
            options: [
                'crud' => 'CRUD Features',
                'trash' => 'Trash Features',
            ]
        );

        $this->generateRepository($features);
    }

    /**
     * @param  array<int|string>  $features
     */
    private function generateRepository(array $features): void
    {
        $contentFeatures = $this->getContentFeatures($features);
        $path = $this->makeDirectory('app/Repositories');
        $content = $this->getContent('repository.stub', [
            'class' => $this->argument('name'),
            'imports' => $contentFeatures['imports'],
            'traits' => $contentFeatures['traits'],
            'dependencies' => $contentFeatures['dependencies'],
            'interfaces' => $contentFeatures['interfaces'],
        ]);
        $file = "{$path}/{$this->argument('name')}.php";
        $this->makeFile($file, $content);
    }

    private function getModelName(): string
    {
        return str_replace('Repository', '', $this->argument('name'));
    }

    /**
     * @param  array<int|string>  $features
     * @return string[]
     */
    private function getContentFeatures(array $features): array
    {
        $imports = '';
        $traits = '';
        $dependencies = '';
        $interfaces_list = [];

        $model = $this->getModelName();

        foreach ($features as $feature) {
            $trait = self::FEATURES[$feature]['name'];
            $interface = self::FEATURES[$feature]['interface'];

            $imports .= "use App\Repositories\Base\Contracts\\{$interface};\n";
            $imports .= "use App\Repositories\Base\Traits\\{$trait};\n";
            $traits .= "use {$trait};\n\t";

            $interfaces_list[] = $interface;
        }

        $dependency_names = array_unique(
            array_merge(
                ...array_map(fn (string|int $feature) => self::FEATURES[$feature]['dependencies'], $features)
            )
        );

        foreach ($dependency_names as $dependency_name) {
            $dependencies .= parent::getContent("repository-dependencies.{$dependency_name}.stub", [
                'model' => $model,
            ]);
            $dependencies .= "\n";

            //@phpstan-ignore-next-line
            if ($dependency_name == 'get_model') {
                $imports .= "\nuse App\Models\\".$model.";\n";
            }
        }

        if (count($interfaces_list)) {
            $interfaces = 'implements '.implode(', ', $interfaces_list);
        } else {
            $interfaces = '';
        }

        return [
            'imports' => $imports,
            'traits' => $traits,
            'dependencies' => $dependencies,
            'interfaces' => $interfaces,
        ];
    }
}
