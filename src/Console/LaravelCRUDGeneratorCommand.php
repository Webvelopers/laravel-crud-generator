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
     *
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->model = $this->argument('name');

        $this->model();
        $this->migration();
        $this->factory();
        $this->seeder();
        $this->storeRequest();
        $this->updateRequest();
        $this->controller();

        $this->info("Laravel CRUD Generator created $this->model model, migration, factory, seeder, request and controller successfully.");
        $this->comment('Please edit migration, factory and seeder files before to run "php artisan migrate --seed" command.');

        return 1;
    }

    /**
     * Get content of the stub files
     *
     * @param string $type
     * @return data
     */
    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . "/../../stubs/$type.stub");
    }

    /**
     * Create the model file
     *
     * @param string $name
     * @return void
     */
    protected function model()
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
    }

    /**
     * Create the migration file
     *
     * @param string $name
     * @return void
     */
    protected function migration()
    {
        $this->callSilent('make:migration', [
            'name' => 'Create' . Str::plural(ucfirst($this->model)) . 'Table',
        ]);
    }

    /**
     * Create the factory file
     *
     * @param string $name
     * @return void
     */
    protected function factory()
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
    }

    /**
     * Create the seeder file
     *
     * @param string $name
     * @return void
     */
    protected function seeder()
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
    }

    /**
     * Create the store request file
     *
     * @param string $name
     * @return void
     */
    protected function storeRequest()
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

        file_put_contents(app_path("/Http/Requests/{$this->model}StoreRequest.php"), $stub);
    }

    /**
     * Create the update request file
     *
     * @param string $name
     * @return void
     */
    protected function updateRequest()
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

        file_put_contents(app_path("/Http/Requests/{$this->model}UpdateRequest.php"), $stub);
    }

    /**
     * Create the controller file and edit the route
     *
     * @param string $name
     * @return void
     */
    protected function controller()
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
        }
    }
}