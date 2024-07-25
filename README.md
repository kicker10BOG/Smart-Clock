# Smart Clock

This is a web app that allows users to create clocks and set alarms.
It is still a work in progress. 
The "Smart" in "Smart Clock" isn't true quite yet, but I am working on it. 

The idea behind this is you can have a central location to manage clocks in your house, or anywhere in the world if you want. 
It's not quite to that point yet though, because each device needs to be refreshed to receive the update clock and alarm settings. 
In the future, they will receive those updates automatically. 

## Features

This app uses Laravel Sail so it is dockerized. 
This also makes it easier to get started quickly. 

Support for multiple users and each user can have multiple clocks.

Clocks have a few configuration settings so they can be customized to your liking. 
More will come as I continue to develop this web app. 

Clocks can also have multiple alarms set. 
Alarms can be toggled on or off completely.
And alarms can also be toggled on or of for specific days of the week. 

More features will come. 
Features that will definitely be added:

* Automatic sync of clock and alarm settings
* Snoozing or dismissing an alarm on one device will also snooze or dismiss it on other devices
* Customizing colors of the clock

I have other ideas that may or may not be added. Things like adding stopwatch and timer options that sync between devices too. 

## Setup

I highly recommend adding the following to your `~/.bashrc` or `~/.zshrc` file.

```
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
This will allow you to just type`sail` instead of `vendor/bin/sail` for all the commands.

You will need to clone this repository then go into the directory it created, `cd Smart-Clock`. 

Once in the directory, run the following command to create your `.env` file. 
```
cp .env.example .env
``` 
Inside your `.env` file, I suggest changing the settings for `DB_USERNAME` and `DB_PASSWORD` to something different. 

Next, generate the encryption key. 
```
sail artisan key:generate
```
Now you need to run the following command to compile the PHP packages. You may need to setup composer if you've never used it before. 
```
composer install
```
Now we get into Sail. This next command will build the docker containers. There are three containers: sail, mariadb, and phpmyadmin. The phpmyadmin container really is not necessary, but it's nice to have during development. The `-d` in this command makes it so it keeps running while you do other stuff. 
```
sail up -d
```
Now, compile the php packages in sail.
```
sail composer install
```
Next, we build the database. 
```
sail artisan migrate
```
Now build the vue pages and components
```
sail npm run build
```
Now you should have a functioning Smart Clock site! 
The default `.env` sets it to run on port 8000, so go to `http://localhost:8000` to see it for yourself! 
Register a new user than start creating clocks! 

I plan to add away to use ssl for https later. 