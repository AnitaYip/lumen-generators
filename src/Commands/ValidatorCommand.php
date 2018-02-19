<?php
/**
 * Created by PhpStorm.
 * User: ayip
 * Date: 6/18/16
 * Time: 9:52 PM
 */

namespace RealPage\Generators\Commands;


class ValidatorCommand extends BaseCommand
{
    protected $name = 'rp:validator';

    protected $description = 'Generates a Validator interface for a RESTful resource';

    public function handle()
    {
        $args = parent::handle();
        parent::writeToTemplate('validator', $args, '/src/Http/Middleware/Validators', 'Validator');
    }
}
