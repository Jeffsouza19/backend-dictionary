<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class CreateRepository extends Command
{
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
    protected $description = 'Create a new Interface and Eloquent';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $arguments = $this->argument('name');

        $arrArgument = explode('/', $arguments);
        $name = end($arrArgument);
        $name = str_replace('Service', '', $name);

        $count = count($arrArgument) -1;
        unset($arrArgument[$count]);

        $nameEloquent =  $name . "Eloquent";
        $nameInterface = $name . "Interface";

        $servicePathEloquent = app_path('Repositories/Eloquents/');
        $servicePathInterface = app_path('Repositories/Interfaces/');

        if (!is_dir(app_path('Repositories'))) {
            mkdir(app_path('Repositories'), 0755, true);
        }

        if (!is_dir(app_path('Repositories/Eloquents/'))) {
            mkdir(app_path('Repositories/Eloquents/'), 0755, true);
        }

        if (!is_dir(app_path('Repositories/Interfaces/'))) {
            mkdir(app_path('Repositories/Interfaces/'), 0755, true);
        }

        foreach ($arrArgument as $value) {
            if (!is_dir($servicePathEloquent . $value)) {
                mkdir($servicePathEloquent . $value, 0755, true);
                $servicePathEloquent .= $value . '/';
            }

            if (!is_dir($servicePathInterface . $value)) {
                mkdir($servicePathInterface . $value, 0755, true);
                $servicePathInterface .= $value . '/';
            }
        }

        $stubEloquent = $this->getStubEloquent(true);
        $stubInterface = $this->getStubInterface(true);

        $servicePathEloquent = $servicePathEloquent . $name . 'Eloquent.php';
        $servicePathInterface = $servicePathInterface . $name . 'Interface.php';

        $stubEloquent = str_replace('{{class}}', $nameEloquent, $stubEloquent);
        $stubEloquent = str_replace('{{interface}}', $nameInterface, $stubEloquent);
        $stubInterface = str_replace('{{class}}', $nameInterface, $stubInterface);

        if (!file_exists($servicePathEloquent) && !file_exists($servicePathInterface) ) {
            file_put_contents($servicePathEloquent, $stubEloquent);
            file_put_contents($servicePathInterface, $stubInterface);
            $this->info('Repository created successfully.');
        } else {
            $this->error('Repository already exists!');
        }
    }

    protected function getStubEloquent($option = false): false|string
    {
        if($option){
            return file_get_contents(__DIR__ . '/stubs/eloquent.base.stub');
        }else{
            return file_get_contents(__DIR__ . '/stubs/eloquent.stub');
        }
    }

    protected function getStubInterface($option = false): false|string
    {
        if($option){
            return file_get_contents(__DIR__ . '/stubs/interface.base.stub');
        }else{
            return file_get_contents(__DIR__ . '/stubs/interface.stub');
        }
    }

    protected function configure(): void
    {
        $this->setName('make:repository')
            ->setDescription('Create a new Interface and Eloquent')
            ->addOption('base', null, InputOption::VALUE_OPTIONAL, 'Create a basics resources if you pass any value');
    }
}
