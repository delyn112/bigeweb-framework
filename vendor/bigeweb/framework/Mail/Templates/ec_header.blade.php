<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-size: 14px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #050e59;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 15px;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #888;
            background-color: #f9f9f9;
        }
        a {
            color: #050e59;
            text-decoration: none;
            font-weight: bold;
        }
        .button {
            background-color: #050e59;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            margin-top: 10px;
        }

        h1, h2, h3, h4, h5, h6{
            margin-bottom: 12px;
            margin-top: 1px;
            margin-left: 0;
            margin-right: 0;
        }

        p{
            margin-bottom: 10px;
            margin-top: 2px;
            margin-left: 0;
            margin-right: 0;
        }

        br{
            margin-bottom: 10px;
        }

        .content{
            line-height: unset;
        }
    </style>
</head>
<body>