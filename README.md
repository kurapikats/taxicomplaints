# TaxiComplaints Philippines
A reporting system that collects information about abusive Taxi Operators / Drivers. Verified reports are sent to LTFRB's support email.

## Installation
TaxiComplaints uses a number of open source projects to work properly:
### System requirements
  - [PHP] 5.5.9+
  - [MySQL]
  - [Composer]
  - [Laravel] 5.1+
  - [Node.js] v0.12+
  - [Bower] 1.6.5+

### Step by step guide to setup a working local copy
Open your favorite Terminal and run these commands.
  1. Clone this repository
    ```sh
    $ git clone {this repo} {directory}
	  ```
  2. Change to target directory and run Composer Install
    ```sh
    $ cd {directory}
    $ composer install
    ```
  3. Change the values for Database, Mail, Facebook sections of .env file.
     See sample below:
    ```sh 
    $ nano .env
    
        APP_ENV=development
        APP_DEBUG=true
        APP_KEY={somerandomcharshere}
        
        DB_HOST={dbhost}
        DB_DATABASE={dbname}
        DB_USERNAME={dbuser}
        DB_PASSWORD={dbpassword}
        
        CACHE_DRIVER=file
        SESSION_DRIVER=file
        QUEUE_DRIVER=database
        
        MAIL_DRIVER=smtp
        MAIL_HOST={yoursmtphost}
        MAIL_PORT={yoursmtpport}
        MAIL_USERNAME={yoursmtpusername}
        MAIL_PASSWORD={yoursmtppassword}
        MAIL_ENCRYPTION=tls
        
        FB_CLIENT_ID={yourfbappid}
        FB_CLIENT_SECRET={yourfbclientsecret}
        FB_REDIRECT_URL={yourfbredirecturl}
    ```
  4. Download and install required Node.js modules
    ```sh
    $ npm install
    ```
  5. Install Bower globally.
    ```sh
    $ sudo npm install -g bower
    ``` 
  6. Download and install required Bower modules
    ```sh
    $ bower install
    ```
  7. Update the Users Table Seeder and change default admin and password: line 17 to 21
    ```sh
    $ cd {database seeds}
    $ nano UserTableSeeder.php
    
        ...
        name           = Jesus B. Nana,
        email          = xyz@email.com,
        password       = bcrypt(xyzpassword),
        contact_number = 09171234567,
        address        = Makati City,
        ...
        
    $ cd {backtoprojectroot}
    ```
  8. Install database migrations
    ```sh
    $ php artisan migrate --seed
    ```
  9. Run the application, defaults to http://localhost:8000/
    ```sh
    $ php artisan serve
    ```

## Version
1.0.0

## Author
Jesus B. Nana (@kurapikats)

support@taxicomplaints.net

## License
TaxiComplaints (C) 2015-2016 is available under MIT license.

The MIT License (MIT)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

   [php]: <http://php.net>
   [mysql]: <http://mysql.com>
   [composer]: <http://getcomposer.org>
   [laravel]: <http://laravel.com>
   [node.js]: <http://nodejs.org>
   [bower]: <http://bower.io>
