<!DOCTYPE html>
<html>
    <head>
        <title>Page Not Found</title>
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
                background-color: #44AD9C;
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
                background-color: #41A291;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Page Not Found!</div>
                <a href="{{ URL::to('/').(isset($back_home)?$back_home:'') }}" class="bt-home">Home</a>
            </div>
        </div>
    </body>
</html>
