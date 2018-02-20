<?php namespace RealPage\Generators\Commands;

class RouteCommand extends BaseCommand {

	protected $name = 'rp:route';

	protected $description = 'Generates RESTful routes.';

    public function handle()
    {
        $args = parent::handle();
        parent::writeToTemplate('routes', $args, '/src/Http/Rotues', 'Routes');
    }
}
