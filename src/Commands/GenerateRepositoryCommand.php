<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class GenerateRepositoryCommand extends GeneratorCommand
{
    const STUB_PATH = __DIR__ . '/Stubs/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : repository class name} {--i : generate interface for contract}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     * 
     * @return string
     */
    protected function getStub()
    {
        # code...
    }

    /**
     * @return string
     */
    protected function getRepositoryStub(): string
    {
        return self::STUB_PATH.'repository.stub';
    }

    protected function getInterfaceStub(): string
    {
        return self::STUB_PATH.'interface.stub';
    }

    protected function getRepositoryInterfaceStub(): string
    {
        return self::STUB_PATH.'repository.interface.stub';
    }

    /**
     * @return string
     */
    protected function getRepositoryName(): string
    {
        return $this->argument('name');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        # get repository name from input
        $repositoryName = $this->getRepositoryName();

        # get interface option
        $isInterface = $this->option('i');

        # check is repository name reserved
        if ($this->isReservedName($repositoryName)) {
            $this->error("The name " . $repositoryName . " is reserved by PHP");

            return false;
        }

        # get qualifyClass from repositoryName
        $name = $this->qualifyClass($repositoryName);

        # get path from repositoryName
        $path = $this->getPath($name);

        # check if has force option and repository is already exists.
        if ((!$this->hasOption('force') || !$this->option('force')) && $this->alreadyExists($repositoryName)) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        # make directory path
        $this->makeDirectory($path);

        # create file in $path
        $this->files->put(
            $path,
            $this->sortImports(
                $this->buildRepositoryClass($name, $isInterface)
            )
        );

        $message = $this->type;

        # whether to create contract
        if ($isInterface) {
            $interfaceName = $repositoryName . 'Interface.php';
            $interfacePath = str_replace($repositoryName . '.php', 'Interfaces/', $path);

            $this->makeDirectory($interfacePath . $interfaceName);

            $this->files->put(
                $interfacePath . $interfaceName,
                $this->sortImports(
                    $this->buildRepoisitoryInterface($repositoryName)
                )
            );

            $message .= ' and Interface';
        }

        $this->info($message . ' created successfully.');

        // return Command::SUCCESS;
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @param $isInterface
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildRepositoryClass(string $name, $isInterface): string
    {
        $stub = $this->files->get(
            $isInterface ? $this->getRepositoryInterfaceStub() : $this->getRepositoryStub()
        );

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildRepoisitoryInterface(string $name): string
    {
        $stub = $this->files->get($this->getInterfaceStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * @param $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Repositories';
    }
}
