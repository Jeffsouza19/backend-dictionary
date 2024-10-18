<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateService extends Command
{
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
    protected $description = 'Create a new Service';

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

        $servicePath = app_path('Services/');

        if (!is_dir(app_path('Services'))) {
            mkdir(app_path('Services'), 0755, true);
        }

        foreach ($arrArgument as $key => $value) {
            if (!is_dir($servicePath . $value)) {
                mkdir($servicePath . $value, 0755, true);
                $servicePath .= $value . '/';
            }
        }

        $name .= 'Service';
        $servicePath = $servicePath . $name . '.php';

        $stub = $this->getStub();

        $stub = str_replace('{{class}}', $name, $stub);

        if (!file_exists($servicePath)) {
            file_put_contents($servicePath, $stub);
            $this->info('Service created successfully.');
        } else {
            $this->error('Service already exists!');
        }
    }

    /**
     * Get the stub for the service.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return file_get_contents(__DIR__ . '/stubs/service.stub');
    }
}
