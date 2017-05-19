var express = require('express'),
    app = express(),
    port = parseInt(process.env.PORT, 10) || 9000;

var bodyParser = require('body-parser');

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
  
app.use(function (req, res, next) {
  res.setHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
  res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
  res.setHeader('Access-Control-Allow-Credentials', true);
  next();
});

var works = [
  {"key": "1", "value": "Toda"},
  {"key": "2", "value": "Tode"},
  {"key": "3", "value": "Todi"},
  {"key": "4", "value": "Todo"},
  {"key": "5", "value": "Todu"}
];

app.post('/login', function (req, res) {
  console.log('In Login:', req.body);

  var message = false;

  if(typeof req.body.usernameBox != 'undefined' && typeof req.body.passwordBox != 'undefined'){
    if(req.body.usernameBox == 'admin' && req.body.passwordBox == 'admin'){
      message = true;
    }
  }

  console.log('Out Login: ' + message);
  res.json({message: message});
});

app.get('/works', function (req, res) {
  console.log('In Works:');
  console.log('Out Works:');
  res.json(works);
});

app.get('/workDetails/:workId', function (req, res) {
  console.log('In WorkDetails:', req.params);

  var id = "XX00" + req.params.workId;
  var details = "--*****&*S&*@ ["+req.params.workId+"]It's a test. skfs@3040-44## ##0495jdnfm3fkf,4lf5";

  console.log('Out WorkDetails:' + id);

  res.json({
        "key": id,
        "value": details
    });
});

app.post('/addNewWork', function (req, res) {
  console.log('In AddNewWork:', req.body);

  var message = false;

  if(typeof req.body.title != 'undefined' && typeof req.body.details != 'undefined'){
    var key = Object.keys(works).length + 1;
    var detail = req.body.title;

    works.push({ "key": key, "value": detail });
    
    message = true;
  }

  console.log('Out AddNewWork: ' + message);
  res.json({message: message});
});

app.listen(port, function () {
  console.log('Server started! At http://localhost:' + port);
});