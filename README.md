# Smart Clock

This is a web app that allows users to create clocks and set alarms.
It is still a work in progress. 
The "Smart" in "Smart Clock" isn't true quite yet, but I am working on it. 

The idea behind this is you can have a central location to manage clocks in your house, or anywhere in the world if you want. 
The clocks use webports via soketi to automatically update everywhere when an event happens. 

The current state is what I originally set out to do, so it is the 1.0 version. 
Of course, ideas to improve it upon have popped up, so I plan to keep working on it.

Currently, a browser needs to be open at the the time an alarm should trigger for it to actually trigger. 
I may look into having the server trigger it in a future update. 
This would also make it possible to have it call some other api so it could trigger some other event, maybe something in your smart home. 

## Features

This app uses Laravel Sail so it is dockerized. 
This also makes it easier to get started quickly. 

Support for multiple users and each user can have multiple clocks.

Clocks have a few configuration settings so they can be customized to your liking. 
The background and font colors can also be customized and set to change at specific times. 
More will come as I continue to develop this web app. 

Clocks can also have multiple alarms set. 
Alarms can be toggled on or off completely.
And alarms can also be toggled on or of for specific days of the week. 

Editing a clock's setting and alarms from one device will automatically update them on any other devices with that clock open. 
Snooze and dismiss also affect other devices with the clock open.
This is done via webports using soketi. 

More features will come. 
Features that will definitely be added:

* Greater customization of the text and layout

I have other ideas that may or may not be added. Things like adding stopwatch and timer options that sync between devices too. 

## Setup

You will need to clone this repository then go into the directory it created, `cd Smart-Clock`. 

Once in the directory, run the following command to create your `.env` file. 
```
cp .env.example .env
``` 
Inside your `.env` file, I suggest changing the settings for `DB_USERNAME` and `DB_PASSWORD` to something different. 

You should also change `PUSHER_APP_ID` to a random number like 75168, `PUSHER_APP_KEY` to a random string like 'gdkfdjlhdjkeew', and `PUSHER_APP_SECRET` to another random string like 'qopikgjpvbmsdnjajlipgjkm'. 

If you plan to access Smart Clock from a different computer besides the one it is hosted on, set `PUSHER_HOST` to the host's LAN IP or domain name. 

Now you need to run the following command to compile the PHP packages. You may need to setup composer if you've never used it before. 
```
composer install
```
Now we get into Sail.

I highly recommend adding the following to your `~/.bashrc` or `~/.zshrc` file.

```
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
This will allow you to just type`sail` instead of `vendor/bin/sail` for all the commands.

This next command will build the docker containers. There are four containers: sail, mariadb, soketi, and phpmyadmin. The phpmyadmin container really is not necessary, but it's nice to have during development. The `-d` in this command makes it so it keeps running while you do other stuff. 
```
sail up -d
```
Next, generate the encryption key. 
```
sail artisan key:generate
```
Now install NPM packages
```
sail npm i
```
Then, we build the database. 
```
sail artisan migrate
```
After that, build the vue pages and components
```
sail npm run build
```
Finally, you should have a functioning Smart Clock site! 
The default `.env` sets it to run on port 8000, so go to `http://localhost:8000` to see it for yourself! 
If you are accessing it from a device other than the host, replace `localhost` with the IP address, for example: `192.168.68.60`. 

Register a new user than start creating clocks! 

I plan to add away to use ssl for https later. 
This will most likely be done using nginx or apache. 
I just haven't looked into it yet. 
If you are just using it on your local network, going without ssl is probably fine. 
Just keep your network secure so potential bad actors can't get in and steal whatever password you use. 
And don't use the same password elsewhere. 