# Tips for developers
When developing yeoman or yo generators here are some techniques and tips that i have found useful.

## After generating a yeoman generator

In your development folder type the following:

	npm link

this will link to your development folder allowing you to test your app locally.
It will also list your generator when the following is typed:

	yo --help
 
then create your test folder and at the command prompt type

	yo yourgenerator-name


## Command line help
### Using the USAGE file in your generator
Sometimes there are requirements on the usage of generator especially when you have sub-generators, sure you can look up the readme.md file but it would be better if you could use the command line to find out the syntax of how to use a particular generator or sub-generators.

- Filename:  USAGE 
- File location: [generator_name]\app

## Information in the readme.md file

## Help
Information on how to use sub-generators can be found by using: 

	yo  [generator_name] --help

### Sample contents of USAGE file

Description:
    Creates Joomla 2.5 and 3.0 files

Options:
    --skip-install: Skips the automatic execution of `bower` and `npm`
      after scaffolding has finished.
    --s: alias --skip-install

Example:
    yo joomla-spc [--skip-install] [--silent]

sub-generators:    
these can be called after the scaffold has been created

- model: yo joomla-spc:model "model-name"
- view: yo joomla-spc:view "view-name" 
- controller: yo joomla-spc:controller "controller-name"
- helper: yo joomla-spc:helper "helper-name"

## When the user types:

	yo joomla-spc --help

### The following will appear:

Usage:
  yo joomla-spc:app [options]

Options:
  -h,   --help  # Print generator's options and usage  Default: false

Description:
    Creates Joomla 2.5 and 3.0 files

Options:

    --skip-install: Skips the automatic execution of `bower` and `npm`
      after scaffolding has finished.

    --s: alias --skip-install

Example:
    yo joomla-spc [--skip-install] [--silent]

sub-generators:
these can be called after the scaffold has been created

    model: yo joomla-spc:model "model-name"
    view: yo joomla-spc:view "view-name"
    controller: yo joomla-spc:controller "controller-name"
    helper: yo joomla-spc:helper "helper-name"

Then the user can copy and paste the sub-generator text to execute the command.
    
    



 