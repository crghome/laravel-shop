<?php

namespace Crghome\Shop\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class ShopCommand extends Command
{
    protected $signature = 'example-command';

    protected $description = 'Example Command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info("Command executed with config param value " . Config::get('crghome-shop.param'));

        return 0;
    }
}