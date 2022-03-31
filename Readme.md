![Mini User App](https://raw.githubusercontent.com/orkhanshafizada/Mini-User-App/main/background.jpeg)

# Mini User App

A small, simple PHP MVC framework skeleton that encapsulates a lot of features surrounded with powerful security layers.

Mini User App is a very simple application, useful for small projects, helps to understand the PHP MVC skeleton and more.

It's not a framework, nor a very basic one but it's not complicated. You can easily install, understand, and use it in any of your projects.

It's indented to remove the complexity of the frameworks. Things like routing, manage user table, and so on are not something I've invented from the scratch, however, they are aggregation of concepts already implemented in other frameworks, but, built in a much simpler way, So, you can understand it, and take it further.

If you need to build bigger application, and take the advantage of most of the features available in frameworks, you can see [CakePHP](http://cakephp.org/), [Laravel](http://laravel.com/), [Symphony](http://symfony.com/).

Either way, It's important to understand the PHP MVC skeleton, and know how to authenticate and authorize, learn about security issues and how can you defeat against, and how to build you own application using the framework.

## Index
+ [Installation](#installation)
+ [Routing](#routing)
+ [Security](#security)
    - [Domain Validation](#referer)
    - [htaccess](#htaccess)
+ [Views](#views)
+ [Models](#models)
+ [Database](#database)
+ [Validation](#validation)
+ [Configurations](#configurations)
+ [Contribute](#contribute)
+ [License](#license)




## Installation <a name="installation"></a>
Install via [Composer](https://getcomposer.org/doc/00-intro.md)

```
	composer install
```

## Routing <a name="routing"></a>


Whenever you make a request to the application, it wil be directed to index.php inside root folder. So, if you make a request: http://localhost/mini-user-app/api/v1/users. This will be splitted and translated into

Controller: UserController
Action Method: index


### Security <a name="security"></a>
The ```Validation.php``` takes care of various security tasks and validation.

#### Domain Validation<a name="referer"></a>

It checks & validates if request is coming from the same domain. Although they can be faked, It's good to keep them as part of our security layers.



#### htacess<a name="htaccess"></a>

+ All requests will be redirected to ```index.php``` in root folder.

## Views <a name="views"></a>

Inside the action method you can make a call to model to get some data, and/or render pages inside _Views_ folder

```php
  //  UserController
  
  public function index()
    {
        $users = Users::all();

        $this->view('user/index', compact( 'users' ) ); // [users: $users]
    }
```

## Models <a name="models"></a>
> In MVC, the model represents the information (the data) and the business rules; the view contains elements of the user interface such as text, form inputs; and the controller manages the communication between the model and the view.
[Source](https://laravel.com/docs/9.x/eloquent)


```php

	//UserController
   public function store($request)
    {
        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_DEFAULT)
        ];

        $validation = new Validation();
        if (!$validation->validate([
            "Name" => [$request->fullname, "alphaNumWithSpaces|minLen(4)|maxLen(30)"],
            "Password" => [$request->password, "minLen(6)|password"],
            "Email" => [$request->email, "email|maxLen(50)"]])) {
            print_r($validation->errors());
            return false;
        }

        $user = Users::insert($data);

        print_r($user);
    }
```

**QueryBuilder**

```php
   // QueryBuilder.php

    public static function insert(array $data): array
    {
        $db = DB::get_instance();
        $conn = $db->get_connection();

        $getColumnsKeys = array_keys($data);
        $implodeColumnKeys = implode(",",$getColumnsKeys);

        $getValues = array_values($data);
        $implodeValues = "'".implode("','",$getValues)."'";

        $table = self::getTable();
        $qry = "insert into $table (".$implodeColumnKeys.") values (".$implodeValues.")";
        $conn->query($qry);


        $lastInsertData = self::find($conn->lastInsertId());
        return $lastInsertData;
    }
```


## Database<a name="database"></a>
PHP Data Objects (PDO) is used for preparing and executing database queries. Inside ```DB``` Class, there are various methods that hides complexity and let's you instantiate database object, prepare, bind, and execute in few lines.

It's recommended to use another database user with more privileges. These privileges needed for mysqldump are mentioned in .env.


## Validation<a name="validation"></a>
Validation is a small library for validating user inputs. All validation rules are inside ``` Validation ``` Class.

#### Usage
```php

$validation = new Validation();

// there are default error messages for each rule
// but, you still can define your custom error message
$validation->addRuleMessage("emailUnique", "The email you entered is already exists");

if(!$validation->validate([
    "User Name" => [$name, "required|alphaNumWithSpaces|minLen(4)|maxLen(30)"],
    "Email" => [$email, "required|email|emailUnique|maxLen(50)"],
    'Password' => [$password,"required|equals(".$confirmPassword.")|minLen(6)|password"],
    'Password Confirmation' => [$confirmPassword, 'required']])) {

    var_dump($validation->errors());
}
```


## Configurations<a name="configurations"></a>
You can change all application configurations in _.env_ file.


### Installation<a name="installation-demo"></a>
Steps:

1. Edit configuration file in _.env_ with your credentials

2. Execute SQL queries in _root_ directory in order

3. Run _composer install_


### Contribute <a name="contribute"></a>

Contribute by creating new issues, sending pull requests on Github or you can send an email at: orxanshefizade@gmail.com


### License <a name="license"></a>
Built under [MIT](http://www.opensource.org/licenses/mit-license.php) license.
