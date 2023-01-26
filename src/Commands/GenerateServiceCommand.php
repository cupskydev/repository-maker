<?php

namespace Cupskydev\RepositoryMaker\Commands;

use Illuminate\Console\GeneratorCommand;

class GenerateServiceCommand extends GeneratorCommand
{
    const STUB_PATH = __DIR__ . '/Stubs/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : service class name} {--i : generate interface for contract}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

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
    protected function getServiceStub(): string
    {
        return self::STUB_PATH.'service.stub';
    }

    protected function getInterfaceStub(): string
    {
        return self::STUB_PATH.'interface.stub';
    }

    protected function getServiceInterfaceStub(): string
    {
        return self::STUB_PATH.'service.interface.stub';
    }

    /**
     * @return string
     */
    protected function getServiceName(): string
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
        # get service name from input
        $serviceName = $this->getServiceName();

        # get interface option
        $isInterface = $this->option('i');

        # check is service name reserved
        if ($this->isReservedName($serviceName)) {
            $this->error("The name " . $serviceName . " is reserved by PHP");

            return false;
        }

        # get qualifyClass from serviceName
        $name = $this->qualifyClass($serviceName);

        # get path from serviceName
        $path = $this->getPath($name);

        # check if has force option and service is already exists.
        if ((!$this->hasOption('force') || !$this->option('force')) && $this->alreadyExists($serviceName)) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        # make directory path
        $this->makeDirectory($path);

        # create file in $path
        $this->files->put(
            $path,
            $this->sortImports(
                $this->buildServiceClass($name, $isInterface)
            )
        );

        $message = $this->type;

        # whether to create contract
        if ($isInterface) {
            $interfaceName = $serviceName . 'Interface.php';
            $interfacePath = str_replace($serviceName . '.php', 'Interfaces/', $path);

            $this->makeDirectory($interfacePath . $interfaceName);

            $this->files->put(
                $interfacePath . $interfaceName,
                $this->sortImports(
                    $this->buildServiceInterface($serviceName)
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
    protected function buildServiceClass(string $name, $isInterface): string
    {
        $stub = $this->files->get(
            $isInterface ? $this->getServiceInterfaceStub() : $this->getServiceStub()
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
    protected function buildServiceInterface(string $name): string
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
        return $rootNamespace . '\Services';
    }
}
