## About the project

These are the Laravel framework project files. Here are all the scripts and methods for the correct functioning of backend.

## Setting up a Laravel server for running this project

This Laravel project is based on Laravel framework 5.8 version. For setting up the Laravel server, it's necessary for you to meet the following requirements on your computer:

- PHP 7.1.3 or higher
- [Composer](https://getcomposer.org/) installed on your computer

> section break for Mac reference

Once you meet these requirements, you need to install the Laravel project installer using Composer:

- Open a command prompt (cmd)
- Type the following command: 

**composer global require laravel/installer**

- Now, download the Laravel project from GitHub, using the green button *Clone or download*, and then you can download it as a ZIP file
- Unzip the project. I recommend you to do this on the Desktop for easier first time access

- Get your cmd placed on the folder where the Laravel project is placed:


-- If you're using Windows 7, your cmd will be placed on **C:\Users\\{Your username}>**. In my case, my username is *Kaiser*, so for me, it looks like this: **C:\Users\Kaiser>**

-- In that case, type **cd Desktop** and hit enter; now your cmd shoul be placed on **C:\Users\\{Your username}\Desktop>**

-- Now, you just have you type **cd {Name of project folder}**. The name of the project folder should be *WooBePro*, but this could vary depending on how you extracted the ZIP.

-- After doing this, your cmd should be placed on **C:\Users\\{Your username}\Desktop\\{Name of project folder}>**. In my particular case, it looks like this: **C:\Users\Kaiser\Desktop\WooBePro>**

-- Once you got there, all you have to do is type the following command:

**php artisan serve**

-- Wait for the server to show this message on cmd:

**Laravel development server started: < http://127.0.0.1:8000>**


I will check what we need when using Windows 10, Linux or Mac


## Setting the database functions

If there weren't any mistakes and your computer meets the requirements previously described, then the Laravel server is running perfectly. Nevertheless, we still need to make some changes before testing the webpage properly.

- **Setting the database:**

To this point, I was assuming you have Apache, PHP, MySQL and phpMyAdmin; all installed on your computer. If not, please install them. 

(If you are using Windows, you can download Wampserver; that basically solves the problem)

(In the case of Linux users, XAMPP can solve it)

(In both cases, make sure you install a version that includes PHP 7.1.3 or higher)

Open your server (nothing will show on your computer), and then open phpMyAdmin on your browser (the address probably is http://localhost/phpmyadmin/), and then log in (usually, the user is root and there is no need of password).

Once you have logged in, create a [new database](https://www.homeandlearn.co.uk/php/images/database/phpMyAdmin_start_screen2.gif) and name it woobe, woobepro, uza, or the name of your preference.

- **Setting the database info in Laravel:**

Now, the next step is to tell Laravel which database it's going to use. For that just go to the Laravel project folder and open the file **.env.example**.

Inside this file, you need to change 3 lines:

**DB_DATABASE=homestead**

**DB_USERNAME=homestead**

**DB_PASSWORD=secret**

Change them like this:

DB_DATABASE=(the name of the database you created)
DB_USERNAME=(the name of phpMyAdmin user, usually *root*)
DB_PASSWORD=(phpMyAdmin password)

In my computer, I have those lines like this:

**DB_DATABASE=woobepro**

**DB_USERNAME=root**

**DB_PASSWORD=**

Save the changes, and then, change the name of the **.env.example** file to **.env**. Now, Laravel will be able to communicate with the database.

- **Setting the tables in the database:**

Once you have done all the previous steps, go to your cmd and type the Ctrl + C key (like copying something). Then, type the following command:

**php artisan migrate --seed**

This commend will set all the tables up on the database. Once you're done with that, you can type again **php artisan serve** and open the Website. but there is one more thing you need to do before checking the website: You need to configure your email sending for the register verification

- **Setting the email address for the automatic mail sender**

This part depends mostly of the email address, the mail driver, the mail host and mail port.

For testing, I used a gmail account I have. Let me explain.

In the **.env** file, There are these lines:

**MAIL_DRIVER=smtp**

**MAIL_HOST=smtp.mailtrap.io**

**MAIL_PORT=2525**

**MAIL_USERNAME=null**

**MAIL_PASSWORD=null**

**MAIL_ENCRYPTION=null**

I changed them like this:

**MAIL_DRIVER=smtp**

**MAIL_HOST=smtp.gmail.com**

**MAIL_PORT=587**

**MAIL_USERNAME=(my gmail address)**

**MAIL_PASSWORD=(my gmail password)**

**MAIL_ENCRYPTION=tls**

These lines must be changed depending on the email provider.

**Finally**, after all this annoying process, if everything went OK, then you can go to your cmd and type **php artisan serve**, and then open the website for checking all its functions and behavior.


## Mac users (64bit)

In case of using Mac OS 64bit, these are the steps to follow:

 1. Download and install XAMPP
 - Download XAMPP for Mac OS from from [this link](https://www.apachefriends.org/xampp-files/7.3.6/xampp-osx-7.3.6-0-vm.dmg), and install it
 - For installing XAMPP on Mac OS, you can follow the instruction given on [this video](https://www.youtube.com/watch?v=XmklVBO89MM)
 2. Install Composer
 - Download Composer from from [this link](https://getcomposer.org/composer.phar)
 - Then open Terminal and type bellow to test:
> php ~/Downloads/composer.phar --version
- Now let’s copy to bin and install it, with below command:
>cp ~/Downloads/composer.phar /usr/local/bin/composer
>sudo chmod +x /usr/local/bin/composer
- Let’s test, if all is good with composer:
>composer --version
- You should get something similar to this:
> Composer version 1.7-dev (sd2guirofdhdsgjkfg3fsdj4bfdhf) 20xx–00–00 21:36:46

From this point you can continue from the "section break for Mac reference"

## Some notes about Frontend

In Laravel, the Frontend is mostly handled through *Blade* templates; nevertheless, this can be handled through some frontend frameworks, such as Vue.js, which comes embedded in Laravel.

These blade templates are stored in the route resources/views, inside the project folder. There you can find some other folders (auth, layouts and vendor) and files:
- accSettings.blade.php
- editProfile.blade.php
- home.blade.php.
- welcome.blade.php

The "welcome" blade view is the homepage that any visitor from the internet should see. This includes the Login and Register links when user is not logged. I made it show a "Home" button in place of login and register links when user is logged. This are the scenarios I made when an user hits "Home" button at "welcome" blade view:

- When user is not verified, then will be redirected to a webpage which asks to verify the email address.
- When user is verified, but still didn't fill the profile details (country, city, type of account, etc), then will be redirected to the details form
- When user is verified and already filled the account details, then will be redirected to "home" blade view, which should be mostly the content for the website users

The "accSettings" and "editProfile" are somehow self-explanatory. 

The first one is the view where the user edits the account settings. Right now I just put a password change form, and a days off form for freelancers.

The second one is the view where the user edit the profile details (country, city, phone number, etc). Inside that blade view I put some necesary scripts with some comments that I hope you find useful.

In both blade view there are some php scripts, because there are content which should not be available for some type of users.

Now, I'll explain some of the other blade views...

- **auth folder**

Inside this folder you can find the login and register related blade views. For example, when you are at the welcome page and you click on "Login", Laravel calls the *login.blade.php* view. Something similar happens when clicking "Register"; Laravel calls the *register.blade.php* view.

The *verify.blade.php* is the view where the new user is asked to verify the email address. It includes a link for making laravel send a new verification mail to the user email address.

The *newuser.blade.php* is the view where the new registered and verified user fills the profile details (country, city, type of account, etc).

Inside the auth folder, there is the passwords folder. The views in there are used when the user wants to reset their password.

- **layouts**

In this folder you can find the layouts for most of the website views. 
The base layout for the entire site is the *app.blade.php* blade template, so most of the styles should be edited there. The *appverify.blade.php* template is very similar, except it is used just for *verify.blade.php* and *newuser.blade.php* views. The main difference is the user menu, which in *appverify.blade.php* template only contains the Logout form.

The *modal.blade.php* is a Bootstrap modal I used for changing the user profile picture. It's included inside the *app.blade.php* template at line 29:
 >@include('layouts.modal')

The *searchusers.blade.php* is the view where the users can see the search results. The styles there are terrible and need some work.

Finally, the *userprofile.blade.php* is the view for the user profile page.

Inside the layouts folder, you can see the options folder. This folder contains some html options that are included in some forms

- **vendor**

Inside the vendor/notifications path you will see the *email.blade.php* view. This is the verification mail that is sent to the new users, containing tha verification link.