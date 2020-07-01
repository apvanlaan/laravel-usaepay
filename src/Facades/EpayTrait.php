<?php

namespace Apvanlaan\UsaEpay\Facades;

use Illuminate\Support\Facades\Facade;

class EpayTrait extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'epaytrait';
    }
}
