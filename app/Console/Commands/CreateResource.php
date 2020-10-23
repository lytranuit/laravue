<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateResource extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:resource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo resource có Frontend và Backend';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    //public function __construct()
    //{
    //    parent::__construct();
    //}

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected function getStub()
    {
        return base_path() . '/stubs/custom/model.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Laravue\Models';
    }
    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($name);

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((!$this->hasOption('force') || !$this->option('force')) && $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->callSilent('make:resource', ['name' => $this->argument('name') . "Resource"]);
        $this->callSilent('create:controller', ['name' => $this->argument('name')]);

        //$this->callSilent('make:controller', ['name' => $this->argument('name') . "Controller", '--resource', '--model' => "Laravue\\Models\\" . $this->argument('name')]);

        $this->info($this->type . ' created successfully.');
    }
}
