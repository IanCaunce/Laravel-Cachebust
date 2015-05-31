#Laravel Cachebust

This package provides a [Laravel 5](http://laravel.com/docs/5.0) service provider and facade making it easier to use the [Cachebust](https://github.com/IanCaunce/cachebust) package.

The [Cachebust](https://github.com/IanCaunce/cachebust) package adds a unique hash to the URI of an asset which updates each time the file changes. It will work with any static asset such as images, stylesheets and javascript. This is helpful for situations when the webserver sets expiry headers on files but updates needs to be pushed immediately to the user.

There are three methods of cachebusting an asset using the package. They are:

###File (default)
The hash is added to the filename of the asset. For example:
<pre>/js/<b>a4bb8768</b>.application.js</pre>

###Path
The hash is added to the path of the asset. For example:
<pre>/js/<b>a4bb8768</b>/application.js</pre>

###Query
The hash is added as a query parameter of the asset's URI. For example: 
<pre>/js/application.js?c=<b>a4bb8768</b></pre>

##Installation

The Laravel cachebust package can be install via [Composer](https://getcomposer.org/) by running:

```
    composer require iancaunce/laravel-cachebust 1.*
```

Or requiring the `iancaunce/laravel-cachebust` package in your project's `composer.json`.

```
{
    "require": {
        "iancaunce/laravel-cachebust": "1.*"
    }
}
```

And then running:

```
composer update iancaunce/laravel-cachebust
```

To use the cachebust service provider and facade, you must first register them in your `config/app.php`.

Find the `providers` key and register the provider:

```
'providers' => array(
    // ...
    'IanCaunce\LaravelCachebust\Providers\CachebustServiceProvider',
)
```

Find the `aliases` key and add the facade alias:

```
'aliases' => array(
    // ...
    'Cachebust' => 'IanCaunce\LaravelCachebust\Facades\CachebustFacade'
)
```

##Configuration
To configure the package, first publish its configuration file to the `config` folder. Go to the root directory of the site and run `php artisan vendor:publish`. You can now edit the configuation in that file.

###enabled
**Type**: `Boolean`  
**Default**: `true`  

Enables or disables cachebusting of assets.

###bustMethod
**Type**: `string`  
**Default**: `file`  
**Allowed Values**: `file`, `path`, `query`  

This dictates the busting method used. See [Configuration Notes](#configuration-notes).

###useFileContents  
**Type**: `Boolean`  
**Default**: `false`  

If set to true, the assets contents will be used to generate the unique hash. This could have a memory impact for large assets as it will be held in memory whilst generating the hash.

###algorithm  
**Type**: `string`  
**Default**: `crc32`  
**Allowed Values**: See [PHP.net](http://php.net/manual/en/function.hash-algos.php) for supported hashing algorithms.  

Sets the hashing algorithm to be used.

###seed
**Type**: `string`  
**Default**: `a4bb8768`  

This can be any string you like. Its purpose is to allow you to invalidate the cache of an asset by changing the hash without updating the file. Simply change this string, and a new hash will be generated.

###publicDir
**Type**: `string`  
**Default**: `public_path()`

Sets the path to the public directory of the assets.

###prefix
**Type**: `string`  
**Default**: ''  

This string prefixes the hash for `file` and `path` busting methods. You only need to set this if you serve non busted assets which also have a hash of the same length as the one in your configuration as part of the filename or path.

###queryParam
**Type**: `string`  
**Default**: 'c'  

The query parameter used when using the query busting method.

##Configuration Notes<a name="configuration-notes"></a>

For `file` and `path` busting, you will need to add a rewrite rule to your `.htaccess` file if you are running `Apache` or a location block if you are running `Nginx`.

###Apache

####File
<pre>
<IfModule mod_rewrite.c>
    RewriteRule ^(.*\/)[0-9a-f]{8}\.(.*)$ $1$2 [DPI]
</IfModule>
</pre>

####Path
<pre>
<IfModule mod_rewrite.c>
    RewriteRule ^(.*\/)[0-9a-f]{8}\/(.*)$ $1$2 [DPI]
</IfModule>
</pre>

####Nginx
Make sure is it the first location block in your configuration file.

####File
<pre>
location ~* "^(.*\/)[0-9a-f]{8}\.(.*)$" {
    try_files $uri $1$2;
}
</pre>

####Path
<pre>
location ~* "^(.*\/)[0-9a-f]{8}\/(.*)$" {
    try_files $uri $1$2;
}
</pre>

The default hash alogorithm used is `crc32` which has a hash length of 8 characters. If you would like to used a different hashing algorithm, you can do so by changing it in the configuration. Update the number in curly brackets to match the length of your chosen algorithm.

For example, if I wanted to use `md5`, my regex would become something like:
<pre>
^(.*\/)[0-9a-f]{<b>32</b>}\/(.*)$
</pre>

If you use a prefix, you will need to add this to the regular expression followed by a dash. For example:

####File
<pre>
^(.*\/)<b>prefix-</b>[0-9a-f]{8}\.(.*)$
</pre>

####Path
<pre>
^(.*\/)<b>prefix-</b>[0-9a-f]{8}\/(.*)$
</pre>

Alternatively, you can use the cachebust class to generate the regex for you using your current configuration. For Example:

```
    print \Cachebust::genRegex();
```

##Usage

Inside a blade template.
```
    //Bust your asset.
    <link rel="stylesheet" href="{{ Cachebust::asset('/js/application.min.js') }}">
```

Using the [Service Container](http://laravel.com/docs/5.0/container)
```
....use IanCaunce\Cachebust\Cachebust;

    //...

    public function __construct(Cachebust $cachebust)
    {
        $bustedAsset = $cachebush->asset('/js/application.min.js');
    }
}
```

Some assets may exist locations other than your main public directory. You can pass the public directory of individual assets to the `asset` function as the second parameter.

```
<link rel="stylesheet" href="{{ Cachebust::asset('/js/application.min.js', 'some/other/public/directory') }}">
```