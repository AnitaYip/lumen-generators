<?php namespace RealPage\Generators\Commands;


class ModelCommand extends BaseCommand {

	protected $name = 'rp:model';

	protected $description = 'Generates a model class for a RESTful resource';

    public function handle()
    {
        $args = parent::handle();

        parent::writeToTemplate('model', $args, '/src/Models', '');
    }
}
