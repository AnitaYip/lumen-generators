<?php
/**
 * Created by PhpStorm.
 * User: ayip
 * Date: 2/19/18
 * Time: 5:19 PM
 */

namespace RealPage\Generators\Commands;

class TestsCommand extends BaseCommand
{
    protected $name = 'rp:tests';

    protected $description = 'Generates a Test classes for a RESTful resource';

    public function handle()
    {
        $args = parent::handle();
        parent::writeToTemplate('testdataprovider', $args, '/tests/functional', 'TestDataProvider');
        parent::writeToTemplate('filtertest', $args, '/tests/functional', 'FilterTest');
        parent::writeToTemplate('readtest', $args, '/tests/functional', 'ReadTest');
        parent::writeToTemplate('sorttest', $args, '/tests/functional', 'SortTest');
        parent::writeToTemplate('writetest', $args, '/tests/functional', 'WriteTest');
    }
}