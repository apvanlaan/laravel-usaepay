<?php

namespace Apvanlaan\UsaEpay\Facades;

use Illuminate\Support\Facades\Facade;

class EpayCustomField extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'epaycustomfield';
    }
}
