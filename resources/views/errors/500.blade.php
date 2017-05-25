<!DOCTYPE html>
<html>
    <head>
        <title>Internal Server Error </title>
        <link href="img/favico-v2.png" type="image/x-icon" rel="shortcut icon" />
        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            .bt-home{
                border: none;
                background-color: #d00021;
                padding: 12px 30px;
                font-size: 14px;
                color: white;
                min-width: 100px;
                outline: none;
                text-decoration: none;
                display: inline-block;
                font-family: sans-serif;
            }
            .bt-home:hover{
                cursor: pointer;
                background-color: #c50120;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Internal Server Error</div>
                <a href="{{ URL::to('/').(isset($back_home)?$back_home:'') }}" class="bt-home">Home</a>
            </div>
        </div>
    </body>
</html>
