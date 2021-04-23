### Introduction
L-modular library gives you the ability to divide your system into multiple packages,
each package has its own required classes
so, your system will become more clearly
in addition to simplify the re-using of the common generated packages such as (user , admin etc. ) in another projects

### Installation

```sh
$ composer require l-modular/package
```
copy service provider link to config/app.php , providers[]

```sh
Modular\Provider\ModularServiceProvider::class,
```
after typing `php artisan`, you can use one of the commands below 
### Base commands
```sh
$ php artisan packages:create {package}
```
this command helps you to create new package by inserting the package name instead  of 
`${package}`.<br/>
#### Notes
- The default master folder is **Modules**, means that if you applied the command in the above, 
the path of your package will be like `{YourProject}/Modules/{package}`
- If you want to create package with custom path, you should append `--path=` to the command in the above
to be like `php artisan packages:create {package} --path={package_full_path}` so the result 
will be like `{YourProject}/{path}/{package}`
```sh
$ php artisan packages:list 
```
the following command helps you show the names of packages you've created before.
```sh
$ php artisan packages:delete {package}
```
This line deletes the package you passed and removes its ServiceProvider from `Config/app`
 
 ### Optional commands
 ```sh
 $ php artisan packages:model {model} {package}
 ```
 this command helps you create a new **model** in the package you chose.
  ```sh
  $ php artisan packages:controller {controller} {package}
  ```
  this command helps you create a new **controller** in the package you chose.
   ```sh
   $ php artisan packages:middleware {middleware} {package}
   ```
   this command helps you create a new **middleware** in the package you chose.
   ```sh
   $ php artisan packages:migration {migration} {package}
   ```
   this command helps you create a new **migration** in the package you chose.
   ```sh
   $ php artisan packages:repo {repository} {package}
   ```
   this command helps you create a new **repository** in the package you chose.
   ```sh
   $ php artisan packages:service {service} {package}
   ```
   this command helps you create a new **service** in the package you chose.
   
### Contact 
**Please**, feel free to contact me if get any kind of issues
 - Email [Amr Saidam](mailto:amr.saidam.94@gmail.com)
 - Upwork [Amr Saidam](https://www.upwork.com/freelancers/~01b9c72b9a4f1f9cfd)
 