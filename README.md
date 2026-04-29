1. [installation](#1-install-via-composer)
2. [start project](#2-start-local-server)
3. [view in browser](#3-open-in-browser)
4. [guide](#4-user-guide)
5. [models](#5-generating-models)
6. [requests](#6-generating-requests)
7. [providers](#7-working-with-providers)
8. [migrations](#8-migrations)
9. [modules or plugin](#9-modules)
10. [classes](#10-php-classes)
11. [fetch data](#11-fetch-data)
12. [insert and update](#12-insert-&-update)
13. [aggregates count](#13-aggregates-count)
14. [soft delete](#14-SoftDelete-eloquent)
15. [query flow](#15-query-flow)

# 🚀 Bigeweb MVC Framework

A lightweight PHP MVC framework built from scratch by **Bigeweb Solution**.  
Designed for simplicity, flexibility, and learning core MVC concepts.
Supports fluent query building, soft deletes, and database operations using PDO.


Features
Fluent query builder (where, get, first, find)
Insert & update operations
Soft delete support (withTrashed, onlyTrashed)
Aggregate functions (count)
Join support
PDO-based secure queries
---

## 📌 Overview

The **Model-View-Controller (MVC)** architecture is a design pattern used to separate application logic into three interconnected components:

- **Model** → Handles data and business logic
- **View** → Manages UI and presentation
- **Controller** → Processes input and connects Model + View

This separation improves:
- ✅ Code organization
- ✅ Maintainability
- ✅ Scalability

---

## 🧠 Architecture Diagram

![MVC Architecture](https://talent500.com/blog/wp-content/uploads/sites/42/2025/09/image-11.png)

---

## ⚙️ Core Features

- 🔀 **Routing System**
    - Clean and user-friendly URLs
    - Automatic route registration

- 🎨 **View Engine**
    - Render dynamic HTML content using blade file
    - Organized template structure

- 🧩 **Controllers**
    - Handle requests and application flow

- 🗄️ **Models**
    - Manage data and business logic

- 🧱 **Facades**
    - Simplify access to core components

- ⚡ **Lightweight & Fast**
    - Built from scratch with minimal dependencies

---

## 📁 Project Structure
project-root/
│
├── app/
│ ├── Controllers/
│ ├── Models/
│
├── resources/
│ ├── views/
│
├── routes/
│
├── public/
│ └── index.php
│
├── vendor/
└── composer.json


---

## 🛠️ Installation

### 1. Install via Composer

composer install bigeweb/framework

## 2. Start Local Server
    To start the local server. From your terminal navigate your directory to the root directory where you have composer 
    Then run 
```bash 
    php -S localhost:8000 -t public or php -S 127.0.0.1:8000 -t public
```
    php -S means php serve with your prefer url followed by which port to be used
    and you are referring the php to serve from public file.

##This is only applicable in development mode, means xampp or any local server.
For live production such as cPanel. You can point your domain to base folder such as public_html
Then use htaccess to redirect all incoming request to public_html

## 3. Open in browser
    Open in your browser by copy and pasting the url generated from your terminal to the browser
    ```bash
    http://localhost:8000 if you specify this or  http://127.0.0.1:8000
   ```


## 4. Usage Guide
🖼️ Working with Views
Navigate to the resources/views directory
Create or edit view files
Add HTML or dynamic content


🔀 Working with Routes
Create a new file in the routes/ directory
Define your routes
Routes are automatically registered
example of a route file can be found inside the route folder.


🎮 Working with Controllers

Add new controllers in:

app/Http/Controllers/
Handle logic and connect models + views
to create a new controller automatically, visit yoururl/ the command below in your browser
```bash
      make:controller/?UserController
````
where UserController is your controller class and file name.
Change this to your class name following php class naming policy. example ProfileController.
To learn more about php class naming policy, scroll down to naming policy paragraph


## 5. Generating Models
To automatically generate model
to create a new model automatically, visit yoururl/ the command below in your browser
  ```bash 
    make:model/?UserModel
  ```
where UserModel is your model class and file name.
Change this to your preffered model file or class name following php class naming policy. example ProfileModel.

## Example Model

```php
class UserModel extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}
```



## 6. Generating Request
To make a requests file for validation
visit yoururl/ the command below in your browser
```bash
make:request/?CreateUserRequest
``` 
where CreateUserRequest is your request class and file name.
Change this to your preffered request file or class name following php class naming policy. example CreateUserProfileRequest.

A request file is used for validating user import where you want the imput filed to be required.
Example when create a new user account, of course you want the first and last name including the email.
Request file can be used to mark this as important.
You can view this in app\Http\Request directory.




## 7. Working with providers
🧩 What is a Service Provider?
A Service Provider is a class that is responsible for:
👉 Registering and setting up services (components) in your application
Think of it as:
🔌 “The place where you plug in and configure features of your app”
You can make use of the same logic as creating .

🧠 Simple analogy
Imagine your app is a house:
Services = electricity, water, internet
Service Provider = the technician who installs and connects them
Without it, nothing is properly set up.

⚙️ In an MVC / PHP framework
A service provider usually does things like:
Register routes
Bind classes into a container
Initialize components
Configure dependencies


```bash 
  class AppServiceProvider
{
    public function register()
    {
        // Register services
    }

    public function boot()
    {
        // Run after all services are registered
    }
}
```

1. register()
   Used to bind services or register services
   Example: database, logger, router
   example of route registration
```bash
 $this->loadUrlFrom(__DIR__.'/../../routes/web.php');
 ```
You can replace web.php with any file name and make sure the file exist
And inside the file you can have the follow code
```bash
    <?php
    
    use Bigeweb\App\Consoles\RunCommands;
    use illuminate\Support\Routes\Route;
    use Bigeweb\App\Http\Controllers\DashboardController;
    
    
    
    Route::get('/', [
        DashboardController::class, 'index'
    ])->name('home');
    
    Route::get('/hi', function(){
    //run the commands
    });
    ?>
```
More about this can be found in routes directory.


## 8. Migrations
To run a new migration file from your browser you can visit your product url/migration name
  ```bash
  url/make:migration/?user
  ```
This will create a user migration file which will be store in database/migrations
to run your migration call this command from your browser
```bash
url/migration
 ```
This will migrate your tables to database.
Note: When you run migration multiple times, its not overwritten unless you manually delete the table
and also remove the file name from migrations table. Then this will re-run with new changes
made to the migration files.

This file come with some default prefill table such as id, timestamp which add created_at and updated_at
to your table.

available usable schema columns are
  ```bash
  Schema::create('table_name', function ($table){
                $table->id(); //automatically primary key and its auto increment
                $table->string('name')->nullable()->default('julie'); //nullable means the table can be empty without showing any error, 
                //default length is 255, you can specify your own length by adding comma after the column name E.g name, 300
                $table->bigInt(string $name);
                $table->int(string $name);
                $table->text(string $name); This can be used to save long text.
                $table->json(string $name);
                $table->decimal(string $name, int $precision = 8, int $scale = 2);
                $table->float(string $name, int $precision = 8, int $scale = 2);
                $table->double(string $name, int $precision = 8, int $scale = 2);
                $table->boolean(string $name);
                $table->enum(string $name, array $allowed);
                $table->bigInt(string $name)->foreign(string $table, string $column = 'id'):
                $table->timestamps();
            });
   ```

To add delete query to foreign key simply add
```bash
onDelete(string $action)  
```
and insert the action name such as cascade or set null
You can also use on update function

 ```bash
 onUpdate(string $action)
 ```

Other available joinable queries are
```bash
unique():
 default(mixed $value) //to set default values
 nullable(): // to allow empty columns
 ```

To learn more about migrations and table, we will update once we have our documentation ready


To drop a migration run
 ```bash
 url/migration:rollback
 ```

More about database
This project allows you to work with the database through the **Model**.  
With the model, you can easily perform common database operations such as:

- **save** a new record
- **update** an existing record
- **create** a new record
- **create or update** a record
- **destroy** or delete a record

The model helps keep database logic clean and organized, so you do not need to write raw queries every time.

### Example

```bash

$user = new User();
$result = $user->save([
"name" = "John Doe";
"email"= "john@example.com"
]);
```

To fine a record
```bash
$user = User->find("id", "1"); or use
$user = User->findorfail("id", "1");
```

To update a record

```bash
$result = $user->update("1", [
"name" = "John Doe";
"email"= "john@example.com"
]);
 ```
or

```bash
$result = $user->updateOrcreate([
"name" = "John Doe";
"email"= "john@example.com"
], ["id" => 1]); 
```
To delete a record
```bash
$user->destroy("id", "1");
```


## 9. Modules
To create extra packages like module
create your directory example
Packages/Plugins
then navigate your terminal to the new directory and run
 ```bash
 composer init
 ```
This will initialize a new project.
fillup your project name and run next until done
license can be MIT.
And finally this will create a new src in your folder. src is same as app which is from base project
And finally your directory can be like this.
project-root/
│
├── Packages/
|──── Plugins
├────── src
│       ├── Controllers/
│       ├── Models/
│
├────── resources/
│       ├── views/
│
├── ────routes/

once this is done. Create a provider and register your routes, configs, views and migrations
Note: to run migration in your package, add the below code to composer json psr4
```bash
Vendorname\\Packagename\\Database\\Migrations : database\\migration
```
vendor name is the name you enter during your composer init process.

And Finally, go to your composer and find repositories array, add your plugin path,
path should follow same way you directory is.

Then run
```bash
composer require plugin vendor name / plugin name
```  
example
```bash
composer require limahost/plugin
```
if you get an error about stable version run
```bash
composer require limahost/plugin:*
 ```
adding * to your
command means require any version.

Once this is done. And composer has complete adding the plugin. Navigate to base project config directory
Find app.php open it and add your new service provider class.
Great, Your plugin is ready for use and now connected to main project.



📈 Future Improvements
✅ Middleware support
✅ Authentication system
✅ API support
🔄 More documentation


## 10. Php Classes
##PHP OOP Classes and Objects
A class is a template for objects, and it defines the structure (properties) and behavior (methods) of an object.
An object is an individual instance of a class.
A class is defined with the class keyword, followed by the name of the class and a pair of curly braces ({}). All its properties and methods go inside the braces.
Assume we create a class named Fruit. The Fruit class can have properties like name and color. In addition, the Fruit class has two methods for setting and getting the details:

```bash
<?php
class Fruit {
  // Properties
  public $name;
  public $color;

  // Method to set the properties
  function set_details($name, $color) {
    $this->name = $name;
    $this->color = $color;
  }

  // Method to display the properties
  function get_details() {
    echo "Name: " . $this->name . ". Color: " . $this->color .".<br>";
  }
}
?>
```
To learn more about this visit [php class lesson](https://www.w3schools.com/php/php_oop_classes_objects.asp)
## 11. Fetch Data

### Get all records

```php
$users = UserModel::get();
```

### Where clause

```php
$users = UserModel::where('name', '=', 'John')->get();
```

### First result

```php
$user = UserModel::where('email', '=', 'john@example.com')->first();
```

### Find by ID

```php
$user = UserModel::find(1);
```


## 12. Insert & Update
## Insert & Update

### Insert

```php
$user = UserModel::save([
    'name' => 'John',
    'email' => 'john@example.com'
]);
```

### Update

```php
$user = UserModel::update(1, [
    'name' => 'John Updated'
]);
```


## 13. Aggregates count

### Count records

```php
$totalUsers = UserModel::count();

$activeUsers = UserModel::where('status', '=', 'active')->count();
```

Internally, this generates:

```sql
SELECT COUNT(*) as total FROM users WHERE status = 'active'
```



## 14. SoftDelete Eloquent
🗑️ Soft Deletes
The framework supports soft deletes, allowing records to be "deleted" without
being permanently removed from the database.
Instead of deleting the record, a deleted_at timestamp is set. This makes it possible to restore the record later.

To use soft deletes in your table, you must add a deleted_at column.
You can do this in two ways:

Option 1: Using the blueprint helper
```bash
$table->softDeletes();
```

Option 2: Manually adding the column
```bash
$table->dateTime('deleted_at')->nullable();
```


Soft deletes allow records to be marked as deleted without removing them from the database.

### Default behavior

Only non-deleted records are returned:

```php
UserModel::get();
```

### Include deleted records

```php
UserModel::withTrashed()->get();
```

### Only deleted records

```php
UserModel::onlyTrashed()->get();
```

### How it works

The query builder automatically adds:

```sql
WHERE deleted_at IS NULL
```

or

```sql
WHERE deleted_at IS NOT NULL
```


⚙️ How It Works
When a record is deleted → deleted_at is set to current timestamp
When not deleted → deleted_at is NULL
Queries automatically ignore soft deleted records (if enabled)
🧩 Usage in Model

To enable soft delete behavior in your model:

use SoftDeletes;


```bash
class User extends Model
{
use SoftDeletes;
}
🔄 Available Methods
$user->delete();        // Soft delete
$user->restore();       // Restore record
$user->forceDelete();   // Permanent delete
```

## 15. Query Flow

1. Static call is made:

```php
UserModel::where('name', '=', 'John')->get();
```

2. `__callStatic()` intercepts the call and forwards it:

```php
static::query()->where(...)
```

3. `query()` creates a new `EloquentQueryBuilder` instance:

```php
new EloquentQueryBuilder(new UserModel())
```

4. Query is built step-by-step:

* SELECT clause
* JOIN clauses
* WHERE conditions
* LIMIT

5. Query is executed using PDO.

6. Results are returned as objects.


## Notes

* Always define `$fillable` to protect against mass assignment.
* Use `count()` instead of `get()` when only counting records.
* Use `first()` when expecting a single result.
* Query builder resets automatically after execution.


🤝 Contributing

Contributions are welcome!

Fork the project
Create your feature branch
Submit a pull request

📄 License

This project is open-source and available under the MIT License.

👨‍💻 Author

Bigeweb Solution
Built with ❤️ using PHP



