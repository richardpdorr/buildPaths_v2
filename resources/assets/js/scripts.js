/**
 * Created by richa on 3/15/2017.
 */
var express = require('express');
var app = express();

// prepare server
app.use('/api', api); // redirect API calls
app.use('/', express.static(__dirname + '/www')); // redirect root
app.use('/js', express.static(__dirname + '/node_modules/bootstrap/dist/js')); // redirect bootstrap JS
app.use('/js', express.static(__dirname + '/node_modules/jquery/dist')); // redirect JS jQuery
app.use('/css', express.static(__dirname + '/node_modules/bootstrap/dist/css')); // redirect CSS bootstrap
//# sourceMappingURL=app.js.map
