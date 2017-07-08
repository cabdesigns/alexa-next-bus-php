'use strict';

var child_process = require('child_process');

module.exports.nextBus = (event, context, callback) => {

  var strToReturn = '';

  var php = './php';
  
  // workaround to get 'sls invoke local' to work
  if (typeof process.env.PWD !== "undefined") {
    php = 'php';
  }

  var proc = child_process.spawn(php, [ "index.php", JSON.stringify(event), { stdio: 'inherit' } ]);

  var dataStr = '';

  proc.stdout.on('data', function (data) {
    dataStr = data.toString();
    strToReturn += dataStr;
  });

  proc.stderr.on('data', function (data) {
    console.log(`stderr: ${data}`);
  });

  proc.on('close', function(code) {
    if(code !== 0) {
      console.log('stdout: ' + dataStr);
      return callback(new Error(`Process exited with non-zero status code ${code}`));
    }

    const response = JSON.parse(strToReturn);

    callback(null, response);
  });
};