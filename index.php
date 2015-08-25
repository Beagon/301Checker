<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Redirection Checker</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/fileinput.min.css">
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
<form class="form-horizontal" method="POST"  enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>301 Checker</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="baseUrl">Base Url:</label>  
  <div class="col-md-4">
  <input id="baseUrl" name="baseUrl" type="text" placeholder="http://www.example.com/" class="form-control input-md" required="">
  <span class="help-block">The base url. (Always end with a /!)</span>  
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="csvfile">Text file with the suffixes:</label>
  <div class="col-md-4">
    <input id="csvfile" name="csvfile" type="file" class="file" data-show-preview="false" data-show-upload="false" required=>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit">Check 301s:</label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Check!</button>
  </div>
</div>

</fieldset>
</form>


<?php

/**
 * File: check301.php
 * Author: Robin Rijkeboer <rmrijkeboer@gmail.com>
 */

if (isset($_POST['baseUrl']) && isset($_FILES['csvfile'])) {
    $baseURL = $_POST['baseUrl'];

    $list = file_get_contents($_FILES['csvfile']['tmp_name']);
    $urls = explode(PHP_EOL, $list);

    $successArray = array();
    $failureArray = array();

    foreach ($urls as $value) {
        $url = $baseURL . $value;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, true); // We'll parse redirect url from header.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // We want to just get redirect url but not to follow it.
        
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //Get location
        preg_match_all('/^Location:(.*)$/mi', $response, $matches);

        if ($status_code == 301 && isset($matches[1][0])) {
            $successArray[] = "Url: " . $url . " redirects to " . $matches[1][0];
        } else {
            $failureArray[] = "Url: " . $url . " doesn't 301 but instead gives status code: " . $status_code . "&#13;";
        }
        curl_close($ch);
    }
    echo "<center><font color='green'>Successes:</font><br/>";
    echo '<textarea rows="10" class="form-control">';
    foreach ($successArray as $key => $value) {
        echo $value;
    }
    echo '</textarea><br />';

    echo "<font color='red'>Failures:</font><br/>";
    echo '<textarea class="form-control" rows="10">';
    foreach ($failureArray as $key => $value) {
        echo $value;
    }
    echo '</textarea></center>';

}

?>

<!-- Please do not remove this -->
<div class="navbar navbar-default navbar-fixed-bottom">
  <div class="container">
    <p class="navbar-text pull-left">Made by <a href="http://www.bitbukket.com">Robin Rijkeboer</a>
    </p>
    <a href="https://github.com/Thunderofnl" class="pull-left github"><img src="img/github.png"/></div>
</div>
<!-- /Please do not remove this -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/fileinput.min.js"></script>
<script>$("#csvfile").fileinput();</script>
</body>
</html>