<?php
/**
 * This file is part of Laravel Cachebust
 *
 * @copyright Copyright (c) Ian Caunce
 * @author    Ian Caunce <iancauncedevelopment@gmail.com>
 * @license   MIT <http://opensource.org/licenses/MIT>
 */

namespace IanCaunce\LaravelCachebust\Facades;

use Illuminate\Support\Facades\Facade;

class CachebustFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'IanCaunce\Cachebust\Cachebust';
    }
}
