<?php
/**
 * This file is part of Laravel Cachebust
 *
 * @copyright Copyright (c) Ian Caunce
 * @author    Ian Caunce <iancauncedevelopment@gmail.com>
 * @license   MIT <http://opensource.org/licenses/MIT>
 */

use IanCaunce\Cachebust\Cachebust;

return [

    /**
     * Dictates if the package is enabled.
     * @var boolean
     */
    'enabled' => true,

    /**
     * Dictates the default busting method
     * @var string
     */
    'bustMethod' => Cachebust::BUST_METHOD_FILE,

    /**
     * Dictates if the file contents should
     * be used when generating the hash.
     * @var string
     */
    'useFileContents' => false,

    /**
     * The hashing algorithm used.
     * @var string
     */
    'algorithm' => 'crc32',

    /**
     * A string seed which alters the file's hash.
     * @var string
     */
    'seed' => 'a4bb8768',

    /**
     * Path to the public directory.
     * @var  string
     */
    'publicDir' => public_path(),

    /**
     * A string which is prefixed to the file before
     * the hash.
     * @var boolean
     */
    'prefix' => '',

    /**
     * The name of the query parameter to be used.
     * @var boolean
     */
    'queryParam' => 'c'
];