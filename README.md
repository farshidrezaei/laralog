# LaraLog
requirement : Laravel ^5.0  

`farshidrezaei/laralog` is a Laravel package which help you to submit your application actions.


## Install

To install through Composer, by run the following command:

``` bash
composer require farshidrezaei/laralog
```

The package will automatically register a service provider.

then publish the package's configuration file, migrations and helpers by running:

``` bash
php artisan vendor:publish --provider="FarshidRezaei\LaraLog"
```

## Documentation

###Configs
in the `configs/laralog.php` you can set the log drivers;

```php
    'db_driver' => true,
    'file_driver' => true,
```
>if `db_driver => true`, logs table will create, logs will submit in database and submit method return submitted log object.
     
>if `file_driver' => true` , logs file will created, logs will submit in log file in "storage/app/LaraLog/" and if `db_driver===false`, submit method return string of submitted log line in the log file.

###Create table
after install package and set configs,for create logs table, run 

```bash
php artisan migrate
```
 
###Usage
 you can use this syntax to submit logs:

```php
FileUploader::new()
    ->level( /* 'info', 'success', 'warning', 'danger' */) //default:'info'
    ->subject( 'Subject of the action' ) //nullable
    ->message( 'Message of the action' ) //nullable
    ->user( /* true (set who did this action.), false (dont set who did this action) */ ) //default:false
    ->submit();
```

for easy usage, you can use helper function, too:

```php
laralog()
    ->level( 'info')
    ->subject( 'Product' )
    ->message( "Product [$product->title]($product->id) created." )
    ->user( true )
    ->submit();
```

you can access to submitted log :
```php
$log = laralog()
       ->level( 'info')
       ->subject( 'Product' )
       ->message( "Product Created" )
       ->user( false )
       ->submit();
```
Assuming `db_driver===true` in `configs/laralog.php`, $log is equal to :

```json
{
    "id": 1,
    "level": "info",
    "subject": "Product",
    "message": "Product created.",
    "user_id": null
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
