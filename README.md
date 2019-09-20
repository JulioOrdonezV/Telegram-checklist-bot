# Telegram-checklist-bot
A simple checklist telegram bot service using PHP Slim framework

This is a telegram bot that manages a simple checklist, 
to add items to the checklist you need to send a message like "/checklist_add item1" 
to delete an item from the list you need to send the message "/checklist_delete item1"

it will delete all that matches with the substring given, so you need to match as much of the string as possible or it will delete several items.

to show the checklist you need to send the command "/checklist"

# Installation

use composer to install the slim framework\\
composer require slim/slim\\
copy the index php file to the directory where you just installed slim\\
use the botfather to create your bot, get the API key and inserted in the code\\
also you need to setup your bot's webhook to point to your web service\\
