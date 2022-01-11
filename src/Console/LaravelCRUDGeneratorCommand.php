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
    protected $signature = 'crud:generator {name : model name for example Post} {--api : create a crud api controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel CRUD Generator is a library, it implements a new command to create: model, migration, factory, seeder, request and CRUD(Create, Read, Update and Delete) controller files with operations, aditional option to generate a API Controller';

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
        $this->request();
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

        //$hide = exec('composer dump-autoload');
        $this->composer->dumpAutoloads();
    }

    /**
     * Create the request file
     *
     * @param string $name
     * @return void
     */
    protected function request()
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
            $this->getStub('Request')
        );

        file_put_contents(app_path("/Http/Requests/{$this->model}Request.php"), $stub);
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
                "\nRoute::resource('" . Str::plural(strtolower($this->model)) . "', 'Api\\{$this->model}Controller')->except(['create', 'edit']);\n"
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
                "\nRoute::resource('" . Str::plural(strtolower($this->model)) . "', '{$this->model}Controller');\n"
            );
        }
    }
}