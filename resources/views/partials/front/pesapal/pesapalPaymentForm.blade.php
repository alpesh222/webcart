<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Merchant Check Out Page</title>
</head>
<body>
<center><h1 id="pesapal_h1">Please do not refresh this page...</h1></center>
@php
    echo $iFrame;
@endphp
</body>
<script>
    setTimeout(function(){document.getElementById("pesapal_h1").style.display ='none';},3000);
</script>
</html>
