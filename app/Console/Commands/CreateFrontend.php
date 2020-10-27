<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateFrontend extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:frontend {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo FrontEnd';

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected function getStub()
    {
        return base_path() . '/stubs/custom/list-view.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $name = $this->getNameInput();
        return base_path() .  "/resources/js/views/" . strtolower($name);
    }
    public function handle()
    {
        $name = $this->getNameInput();
        $path = base_path() .  "/resources/js/views/" . strtolower($name) . "/List.vue";


        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type . ' created successfully.');
    }
}
