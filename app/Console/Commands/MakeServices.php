<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\GenericMakeCommand;

use function Laravel\Prompts\multiselect;

class MakeServices extends GenericMakeCommand
{
    private const FEATURES = [
        'crud' => [
            'name' => 'CRUDMethods',
            'dependencies' => ['get_repository'],
            'interface' => 'CRUDInterface',
        ],
        'trash' => [
            'name' => 'TrashMethods',
            'dependencies' => ['get_repository'],
            'interface' => 'TrashInterface',
        ],
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    public function handle(): void
    {
        $features = multiselect(
            label: 'Do you want to add any extra modules?',
            options: [
                'crud' => 'CRUD Features',
                'trash' => 'Trash Features',
            ]
        );

        $this->generateService($features);
    }

    /**
     * @param  array<int|string>  $features
     */
    private function generateService(array $features): void
    {
        $contentFeatures = $this->getContentFeatures($features);
        $path = $this->makeDirectory('app/Services');
        $content = $this->getContent('service.stub', [
            'class' => $this->argument('name'),
            'imports' => $contentFeatures['imports'],
            'traits' => $contentFeatures['traits'],
            'dependencies' => $contentFeatures['dependencies'],
            'interfaces' => $contentFeatures['interfaces'],
        ]);
        $file = "{$path}/{$this->argument('name')}.php";
        $this->makeFile($file, $content);
    }

    private function getRepositoryName(): string
    {
        return str_replace('Service', 'Repository', $this->argument('name'));
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

        $repository = $this->getRepositoryName();

        foreach ($features as $feature) {
            $trait = self::FEATURES[$feature]['name'];
            $interface = self::FEATURES[$feature]['interface'];

            $imports .= "use App\Services\Base\Contracts\\{$interface};\n";
            $imports .= "use App\Services\Base\Traits\\{$trait};\n";
            $traits .= "use {$trait};\n\t";

            $interfaces_list[] = $interface;
        }

        $dependency_names = array_unique(
            array_merge(
                ...array_map(fn (string|int $feature) => self::FEATURES[$feature]['dependencies'], $features)
            )
        );

        foreach ($dependency_names as $dependency_name) {
            $dependencies .= parent::getContent("service-dependencies.{$dependency_name}.stub", [
                'repository' => $repository,
            ]);
            $dependencies .= "\n";

            //@phpstan-ignore-next-line
            if ($dependency_name == 'get_repostory') {
                $imports .= "\nuse App\Repositories\\".$repository.";\n";
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
