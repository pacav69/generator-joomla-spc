# ![SilverPC Logo](http://cldup.com/I-R7eDB7Q0.png)

> Helping you build a better Joomla

# Generator-joomla-spc [![Build Status](https://secure.travis-ci.org/pacav69/generator-joomla-spc.png?branch=master)](https://travis-ci.org/pacav69/generator-joomla-spc)
[![Built with Grunt](https://cdn.gruntjs.com/builtwith.png)](http://gruntjs.com/)

Based on generator-joomla-component by Sean Goresht

A component generator for [Yeoman](http://yeoman.io).

## What It Does (Better)
Using this generator, you can quickly and effortlessly *scaffold* out a new [joomla](http://joomla.org) component, using recommended MVC design pattern and coding standards.  These include:

* Internationalization language files
* Tabs for indents
* CamelCase variable notation
* Proper MVC architecture
* PHPDocumentor stubs for every method, as well as page-level doc blocks
* Uses ``'`` over ``"``, because that's what the official Joomla library uses

So rather than manually creating your own ``config.xml`` and other config files, you just need to load up this generator, type in your options, and everything is set up for you.  If you want to add a new model, view, or controller, just use the sub-generators!

What this generator does is place the code in a app folder for editing.

Stores user data in config.json in home directory for later usage with generators.

Makes use of gruntjs to do the following:


- zip files for deployment


## Getting Started

### What is Yeoman?

Trick question. It's not a thing. It's this guy:

![](http://i.imgur.com/JHaAlBJ.png)

Basically, he wears a top hat, lives in your computer, and waits for you to tell him what kind of application you wish to create.

Not every new computer comes with a Yeoman pre-installed. He lives in the [npm](https://npmjs.org) package repository. You only have to ask for him once, then he packs up and moves into your hard drive. *Make sure you clean up, he likes new and shiny things.*

```
$ npm install -g yo
```
## Other requirements

Gruntjs-cli


### Yeoman Generators

Yeoman travels light. He didn't pack any generators when he moved in. You can think of a generator like a plug-in. You get to choose what type of application you wish to create, such as a Backbone application or even a Chrome extension.

Copy from git repository

or

To install generator-joomla-spc from npm, run:

```
$ npm install -g generator-joomla-spc
```

Finally, initiate the generator:

```
$ yo joomla-spc
```

## Sub-generators
There are currently **4** subgenerators planned; only ``controller`` is working right now:

1. *model*: ``yo joomla-spc:model "model-name"`` - *Not yet implemented*
2. *view*: ``yo joomla-spc:view "view-name"`` - *Not yet implemented*
3. *controller*: ``yo joomla-spc:controller "controller-name"`` 
4. *helper*: ``yo joomla-spc:helper "helper-name"`` - *Not yet implemented*

## Component template levels

### basic
Provides a basic level of scafolding for developing a basic component.

### intermediate
Based on Joomla's HelloWorld sample.
Provides a intermediate level of scaffolding for developing a intermediate component.
Includes an sql file and install script.php file.
Demonstrates the use of views of singular and plural types.
Illustrates the use of graphics in menus.

### advanced
Provides a intermediate level of scaffolding for developing a intermediate component.
Includes an sql file and install script.php file.
Demonstrates the use of views of singular and plural types.
Demonstrates the use of a control panel for more complex projects.

## Other generators

Select from list upon startup of *yo joomla-spc*

*component*: *implemented*


- Component levels of basic, intermediate and advanced

*module*:*Not yet implemented*

*plugin*: *implemented*

*template*: *Not yet implemented*

*templateadmin*: *Not yet implemented*

Each generator creates a new file with phpdocumentor and joomla standards, packaged and subpackaged as needed

## Usage

### In this project directory
modify the index.coffee scripts

run

	grunt 

this will compile the coffee scripts manually.

Other commands

	grunt watch

this will watch changes in coffee script files, then carry out coffeelint, compile coffee scripts and use jshint on js files. 

to use temporarily 
open up a command prompt in this project directory
type

	npm link

this will allow yo joomla-spc to be run in the working directory

### For the working directory

Create a working directory
open up a command prompt in the working directory

    yo joomla-spc


after running the generator files will be stored in app directory
modify files to your project requirements

from the command prompt in the working directory type 

    grunt 

this will zip (grunt's default task) up files located in app directory and place the zip file in dist directory.

## Using the extensions

Recommend going [here](https://bitnami.com/stack/joomla) to download and install bitnami joomla for your system.

After creating the extension in your working directory run 

	grunt 

and the default task will zip up the app directory and place the file in the dist directory. This file then can be installed into Joomla using the normal procedure. By installing the extension it will register the extension and have the ability to be directly edited and debugged within the Joomla installation.
The generated extension can be zipped up and installed by default.

## Reference
The components and starting logic are derived form the book [Learning Joomla 3 Extension Development Third Edition](http://www.amazon.com/Learning-Joomla-Extension-Development-Third-Edition/dp/1782168370) (you can also find this on *other* alternative locations on the internet [by googling](https://encrypted.google.com/search?{google:acceptedSuggestion}oq=learning+joomla+3+extension+development&sourceid=chrome&ie=UTF-8&q=learning+joomla+3+extension+development))

 Joomla! Programming By Mark Dexter, Louis Landry [here](http://www.informit.com/store/joomla-programming-9780132780810)

[joomla-platform-examples](https://github.com/joomla/joomla-platform-examples)

[sublime text 2 joomla snippets](https://github.com/joomlapro/joomla-bundle "sublime text 2 joomla snippets")

# To-do
read the todo.txt file

## Help
Information on how to use sub-generators can be found by using:

	yo  joomla-spc --help

or read the USAGE file in the app directory.

## License
[MIT License](http://en.wikipedia.org/wiki/MIT_License)
