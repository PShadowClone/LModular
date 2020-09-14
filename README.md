### Introduction
L-modular library gives you the ability to divide your system into multiple packages,
each package has its own required classes
so, your system will become more clearly
in addition to simplify the re-using of the common generated packages such as (user , admin etc. ) in another projects

### Installation

```bash
$ composer require l-modular/package
```
copy service provider link to config/app.php , providers[]

```bash
Modular\Provider\ModularServiceProvider::class,
```
after typing `php artisan` you can use one of the commands below 
### Library commands
- packages:create `packageName`
- packages:list 
- packages:delete `packageName`
 
### The generated files for each package
- Config
- Controllers
- Middlewares
- Migrations
- Models
- Providers
- Resources
- Routes

### Contact 
Contact email `amr.saidam.94@gmail.com`
 