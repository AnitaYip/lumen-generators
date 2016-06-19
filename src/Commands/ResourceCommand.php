<?php namespace RealPage\Generators\Commands;


class ResourceCommand extends BaseCommand {

    protected $signature = 'rp:resource
        {name : Name of the resource.}';

    protected $description = 'Generates a model, controller, repository interface,
    repository, schema (json), validator and routes for RESTful resource';

    protected $fields;

    private $commands = [
        'rp:model',
        'rp:controller',
        'rp:repointf',
        'rp:repo',
        'rp:schema',
        'rp:validator',
        'rp:route'
    ];

    public function handle()
    {
        $resourceName = $this->argument('name');
        $modelName = ucwords(camel_case($resourceName));

        foreach ($this->commands as $command) {
            $this->call($command, [
                'name' => $modelName
            ]);
        }
    }
}
