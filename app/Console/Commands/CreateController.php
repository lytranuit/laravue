<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo Controller Resource';

    protected function getStub()
    {
        return base_path() . '/stubs/custom/controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }
    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name . "Controller");

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

        $this->info($this->type . ' created successfully.');
    }
}
