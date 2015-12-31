
#!/usr/bin/env node
'use strict';
var fs = require('fs');
var path = require('path');
var chalk = require('chalk');
var updateNotifier = require('update-notifier');
var Insight = require('insight');
var yosay = require('yosay');
var stringLength = require('string-length');
var rootCheck = require('root-check');
var meow = require('meow');
var pkg = require('../package.json');
var Router = require('./router');

var cli = meow({
  help: false,
  pkg: pkg
});

var opts = cli.flags;
var args = cli.input;
var cmd = args[0];
var insight;



function updateCheck() {
  var notifier = updateNotifier({pkg: pkg});
  var message = [];

  if (notifier.update) {
    message.push('Update available: ' + chalk.green.bold(notifier.update.latest) + chalk.gray(' (current: ' + notifier.update.current + ')'));
    message.push('Run ' + chalk.magenta('npm install -g ' + pkg.name) + ' to update.');
    console.log(yosay(message.join(' '), {maxLength: stringLength(message[0])}));
  }
}