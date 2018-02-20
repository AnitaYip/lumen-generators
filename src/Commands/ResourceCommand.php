<?php namespace RealPage\Generators\Commands;

class ResourceCommand extends BaseCommand {

    protected $name = 'rp:resource';

    protected $description = 'Generates a model, controller, repository,
     schema (json-api), validator and routes for RESTful resource';

    protected $fields;

    private $commands = [
        'rp:model',
        'rp:controller',
        'rp:repo',
        'rp:schema',
        'rp:validator',
        'rp:route',
        'rp:tests'
    ];

    public function handle()
    {
        $arguments = parent::handle();

        foreach ($this->commands as $command) {
            $this->call($command, $arguments);
        }
    }
}
