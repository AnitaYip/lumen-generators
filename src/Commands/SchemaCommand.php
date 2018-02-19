<?php
/**
 * Created by PhpStorm.
 * User: ayip
 * Date: 6/18/16
 * Time: 9:35 PM
 */

namespace RealPage\Generators\Commands;


class SchemaCommand extends BaseCommand
{
    protected $name = 'rp:schema';

    protected $description = 'Generates a Schema class for a RESTful resource';

    public function handle()
    {
        $args = parent::handle();
        parent::writeToTemplate('schema', $args, '/src/Schemas', 'Schema');
    }
}
