<?php namespace RealPage\Generators\Commands;

class ControllerCommand extends BaseCommand {

    protected $name = 'rp:controller';

    protected $description = 'Generates RESTful controller using the ApiController trait';

    public function handle()
    {
        $args = parent::handle();
        parent::writeToTemplate('controller', $args, '/src/Http/Controllers', 'Controller');
    }
}
