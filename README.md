# generator-joomla-spc [![Build Status](https://secure.travis-ci.org/srsgores/generator-joomla-spc.png?branch=master)](https://travis-ci.org/srsgores/generator-joomla-spc)
Based on generator-joomla-component by Sean Goresht
# generator-joomla-component [![Build Status](https://secure.travis-ci.org/srsgores/generator-joomla-component.png?branch=master)](https://travis-ci.org/srsgores/generator-joomla-component)

A component generator for [Yeoman](http://yeoman.io).

## What It Does (Better)
Using this generator, you can quickly and effortlessly *scaffold* out a new [joomla](http://joomla.org) component, using recommended MVC design pattern and coding standards.  These include:

* Internationalization language files
* Tabs for indents
* CamelCase variable notation
* Proper MVC architecture
* PHPDocumentor stubs for every method, as well as page-level doc blocks
* Uses ``'`` over ``"``, because that's what the official Joomla library uses

So rather than manually creating your own ``config.xml`` and other config files, you just need to load up this generator, type in your options, and everything is set up for you.  If you want to add a new model, view, or controller, just use the subgenerators!

What this generator does is place the code in a src folder for editing.

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

### Yeoman Generators

Yeoman travels light. He didn't pack any generators when he moved in. You can think of a generator like a plug-in. You get to choose what type of application you wish to create, such as a Backbone application or even a Chrome extension.

To install generator-joomla-component from npm, run:

```
$ npm install -g generator-joomla-component
```

Finally, initiate the generator:

```
$ yo joomla-component
```

## Subgenerators
There are currently **4** subgenerators planned; only ``controller`` is working right now:

1. *model*: ``yo joomla-spc:model "model-name"`` - *Not yet implemented*
2. *view*: ``yo joomla-spc:view "view-name"`` - *Not yet implemented*
3. *controller*: ``yo joomla-spc:controller "controller-name"`` - **NEW**
4. *helper*: ``yo joomla-spc:helper "helper-name"`` - *Not yet implemented*


Each generator creates a new file with phpdocumentor and joomla standards, packaged and subpackaged as needed

## Reference
The components and starting logic are derived form the book [Learning Joomla 3 Extension Development Third Edition](http://www.amazon.com/Learning-Joomla-Extension-Development-Third-Edition/dp/1782168370) (you can also find this on *other* alternative locations on the internet [by googling](https://encrypted.google.com/search?{google:acceptedSuggestion}oq=learning+joomla+3+extension+development&sourceid=chrome&ie=UTF-8&q=learning+joomla+3+extension+development))

[joomla-platform-examples](https://github.com/joomla/joomla-platform-examples)

[sublime text 2 joomla snippets](https://github.com/joomlapro/joomla-bundle "sublime text 2 joomla snippets")

## License
[MIT License](http://en.wikipedia.org/wiki/MIT_License)
