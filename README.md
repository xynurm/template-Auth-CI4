# Template Login Using Myth-Auth and Faker

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

## Installation & Setup

1. Git clone this project, and configure **.env** .
2. Then `composer update` whenever there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply to your `app` folder. The affected files can be copied or merged from `vendor/codeigniter4/framework/app`.

## Database 
### Create migration database 
1. Make migration database using command line :
```shell
    > php spark make:migration <class>
```
will create a file at `app/Database/Migrations`

2. Example usage
 ```
 <?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBlog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'blog_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'blog_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'blog_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('blog_id', true);
        $this->forge->createTable('blog');
    }

    public function down()
    {
        $this->forge->dropTable('blog');
    }
}
  ```

  ### Use Faker in migration database seeder
  1. Create a new file  `app/Database/Seeds` example `CustomerSeeder.php`.

  2. Use `Faker\Factory::create()` to create and initialize a faker generator, which can generate data by accessing properties named after the type of data you want in `CustomerSeeder.php` example usage 
  ```
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'name' => 'doe',
        //         'address'    => 'Jln Cde No. 123',
        //     ],
        //     [
        //         'name' => 'lorem',
        //         'address'    => 'Jln Fgh No. 123',
        //     ],
          
        // ];


        // Simple Queries
        // $this->db->query('INSERT INTO customers (name, address) VALUES(:name:, :address:)', $data);

        // Using Query Builder
        // $this->db->table('customers')->insert($data);
        
        // Using Query Builder insert many of data
        // $this->db->table('customers')->insertBatch($data);

        // using faker
        $faker = \Faker\Factory::create('id_ID');

        for($i = 0; $i < 100; $i++){     
        $data = [
                'name' => $faker->name,
                'address'    => $faker->address,          
        ];
        $this->db->table('customers')->insert($data);
        }
    } 
}
  ```

  3. You can also seed data from the command line, as part of the Migrations CLI tools, if you don’t want to create a dedicated controller:
```shell
    > php spark db:seed CustomerSeeder
```


## Configuration myth-auth

- [myth-auth](https://github.com/lonnieezell/myth-auth) source myth-auth library
Once installed you need to configure the framework to use the **Myth\Auth** library.
In your application, perform the following setup: 

1. Edit **app/Config/Email.php** and verify that a **fromName** and **fromEmail** are set 
    as that is used when sending emails for password reset, etc. 

2. Edit **app/Config/Validation.php** and add the following value to the **ruleSets** array: 
    `\Myth\Auth\Authentication\Passwords\ValidationRules::class`

3. Ensure your database is setup correctly, then run the Auth migrations: 
```shell
    > php spark migrate -all  
```

NOTE: This library uses your application's cache settings to reduce database lookups. If you want
to make use of this, simply make sure that your are using a cache engine other than `dummy` and 
it is properly setup. The `GroupModel` and `PermissionModel` will handle caching and invalidation
in the background for you.

If you want to disabled every registered user and reset password will receive an email message, you can edit at **vendor/myth-auth/src/config/Auth.php** change value `public $requireActivation` and`public $activeResetter` to `null` 