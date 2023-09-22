<?php

namespace Webvelopers\LaravelCRUDGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LaravelCRUDGeneratorCommand extends Command
{
    /**
     * The name of model
     *
     * @var string
     */
    protected $model;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate {name : model name for example Post} {--api : create a crud api controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'it implements a new command to create: model, migration, factory, seeder, request and controller(resources) files with operations, with additional option to generate a full API Controller';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new command instance.
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->model = $this->argument('name');

        $this->components->info("Laravel CRUD Generator is creating $this->model model.");
        $model = $this->model();
        $this->components->info("Model <bold>[$model]</bold> created successfully.");

        $this->components->info("Laravel CRUD Generator is creating $this->model migration.");
        $this->migration();

        $this->components->info("Laravel CRUD Generator is creating $this->model factory.");
        $factory = $this->factory();
        $this->components->info("Factory <bold>[$factory]</bold> created successfully.");

        $this->components->info("Laravel CRUD Generator is creating $this->model seeder.");
        $seeder = $this->seeder();
        $this->components->info("Seeder <bold>[$seeder]</bold> created successfully.");

        $this->components->info("Laravel CRUD Generator is creating $this->model store request.");
        $storeRequest = $this->storeRequest();
        $this->components->info("Store Request <bold>[$storeRequest]</bold> created successfully.");

        $this->components->info("Laravel CRUD Generator is creating $this->model update request.");
        $updateRequest = $this->updateRequest();
        $this->components->info("Update Request <bold>[$updateRequest]</bold> created successfully.");

        $this->components->info("Laravel CRUD Generator is creating $this->model controller.");
        $controller = $this->controller();
        $this->components->info("Controller <bold>[$controller]</bold> created successfully.");

        $this->components->info("Laravel CRUD Generator created <bold>$this->model</bold> model, migration, factory, seeder, request and controller successfully.");
        $this->comment('Please edit migration, factory and seeder files before to run "php artisan migrate --seed" command.');

        return 1;
    }

    /**
     * Get content of the stub files
     */
    protected function getStub(string $type): string
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }

    /**
     * Create the model file
     */
    protected function model(): string
    {
        if (!file_exists($path = app_path('/Models'))) {
            mkdir($path, 0777, true);
        }

        $stub = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->model,
                Str::plural(strtolower($this->model)),
            ],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/Models/{$this->model}.php"), $stub);

        return app_path("/Models/{$this->model}.php");
    }

    /**
     * Create the migration file
     */
    protected function migration(): void
    {
        $this->call('make:migration', [
            'name' => 'Create' . Str::plural(ucfirst($this->model)) . 'Table',
        ]);
    }

    /**
     * Create the factory file
     */
    protected function factory(): string
    {
        $stub = str_replace(
            [
                '{{modelName}}',
            ],
            [
                $this->model,
            ],
            $this->getStub('Factory')
        );

        file_put_contents(database_path("/factories/{$this->model}Factory.php"), $stub);

        return database_path("/factories/{$this->model}Factory.php");
    }

    /**
     * Create the seeder file
     */
    protected function seeder(): string
    {
        $stub = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $this->model,
                strtolower($this->model),
            ],
            $this->getStub('Seeder')
        );

        file_put_contents(database_path("/seeders/{$this->model}Seeder.php"), $stub);

        $this->composer->dumpAutoloads();

        return database_path("/seeders/{$this->model}Seeder.php");
    }

    /**
     * Create the store request file
     */
    protected function storeRequest(): string
    {
        if (!file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        $stub = str_replace(
            [
                '{{modelName}}',
            ],
            [
                $this->model,
            ],
            $this->getStub('StoreRequest')
        );

        file_put_contents(app_path("/Http/Requests/Store{$this->model}Request.php"), $stub);

        return app_path("/Http/Requests/Store{$this->model}Request.php");
    }

    /**
     * Create the update request file
     */
    protected function updateRequest(): string
    {
        if (!file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        $stub = str_replace(
            [
                '{{modelName}}',
            ],
            [
                $this->model,
            ],
            $this->getStub('UpdateRequest')
        );

        file_put_contents(app_path("/Http/Requests/Update{$this->model}Request.php"), $stub);

        return app_path("/Http/Requests/Update{$this->model}Request.php");
    }

    /**
     * Create the controller file and edit the route
     */
    protected function controller(): string
    {
        if ($this->option('api')) {
            if (!file_exists($path = app_path('/Http/Controllers/Api'))) {
                mkdir($path, 0777, true);
            }

            $stub = str_replace(
                [
                    '{{modelName}}',
                    '{{modelNamePluralLowerCase}}',
                    '{{modelNameSingularLowerCase}}',
                ],
                [
                    $this->model,
                    strtolower(Str::plural($this->model)),
                    strtolower($this->model),
                ],
                $this->getStub('ApiController')
            );

            file_put_contents(app_path("/Http/Controllers/Api/{$this->model}Controller.php"), $stub);

            File::append(
                base_path('routes/api.php'),
                "\nRoute::apiResource('" . Str::plural(strtolower($this->model)) . "', \\App\\Http\\Controllers\\Api\\{$this->model}Controller::class);\n"
            );

            return app_path("/Http/Controllers/Api/{$this->model}Controller.php");
        } else {
            $stub = str_replace(
                [
                    '{{modelName}}',
                    '{{modelNamePluralLowerCase}}',
                    '{{modelNameSingularLowerCase}}',
                ],
                [
                    $this->model,
                    strtolower(Str::plural($this->model)),
                    strtolower($this->model),
                ],
                $this->getStub('Controller')
            );

            file_put_contents(app_path("/Http/Controllers/{$this->model}Controller.php"), $stub);

            File::append(
                base_path('routes/web.php'),
                "\nRoute::resource('" . Str::plural(strtolower($this->model)) . "', \\App\\Http\\Controllers\\{$this->model}Controller::class);\n"
            );

            return app_path("/Http/Controllers/{$this->model}Controller.php");
        }
    }
}
