/**
* Config file
*/

'use strict';

var path = require('path')
  , fs   = require('fs')

module.exports = {
    getConfig: getConfig
  , createConfig: createConfig
  , updateVersion: updateVersion
}

var home            = process.env.HOME || process.env.USERPROFILE
  , configDirectory = path.join(home, '.yeoman-spc')
  , configPath      = path.join(configDirectory, 'config.json')
  , defaults = {
      authorName: 'example'
    , authorURL:  'somedomain.com'
    , authorEmail:  'email@somedomain.com'
    , versionno: '1.0.0'
  }

/**
 *  Read the config file
 *  And trigger the callback function with errors and
 *  datas as parameters
 */
function getConfig(cb) {
debugger
 try {
    fs.readFile(configPath, 'utf8', function(err, data) {
      if (err) {
        cb(true, defaults)
        return
      }

      cb(false, JSON.parse(data))

    })
  }
  catch(e) {
    cb(true, defaults)
  }
}

/**
 *  Create the config file
 *
 *  @param object values Values to write in the config file
 *  @param function cb Callback function
 */
function createConfig(values, cb) {
  var configValues = {
      authorName: values.authorName || defaults.authorName
    , authorURL:  values.authorURL || defaults.authorURL
    , authorEmail:   values.authorEmail || defaults.authorEmail
    , versionno: values.versionno || defaults.versionno
  }

  var configData = ['{\n\t'
      , '"authorName": "'+configValues.authorName+'",\n\t'
      , '"authorURL": "'+configValues.authorURL+'",\n\t'
      , '"authorEmail": "'+configValues.authorEmail+'",\n\t'
      , '"versionno": "'+configValues.versionno+'"\n'
      , '}'
  ].join('')

  fs.mkdir(configDirectory, '0777', function() {
    fs.writeFile(configPath, configData, 'utf8', cb)
  })
}

/**
 * Update the config file to bump
 * the Wordpress version
 *
 * @param string version Wordpress version
 */
function updateVersion(versionno) {
  getConfig(function(err, values) {
    var newValues = {
        authorName: values.authorName
      , authorURL:  values.authorURL
      , authorEmail:   values.authorEmail
      , versionno: versionno
    }

    createConfig(newValues)
  })
}
