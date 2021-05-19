<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/favicon.png">
    <title>Url not found</title>
    <style>
    *
    {
        padding: 0px;
        margin: 0px;
    }
    html, body
    {
        width: 100%;
        height: 100%;
    }
    body
    {
        background-color: #89A8D1;
    }
    .center
    {
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: bold;
        color: whitesmoke;
    }
    h1
    {
        font-size: 240px;
    }
    span
    {
        font-size: 24px !important;
    }
    </style>
</head>
<body>
    <div class="center">
        <h1>404</h1><span>Check route: <?= $route ?></span>
    </div>
</body>
</html>