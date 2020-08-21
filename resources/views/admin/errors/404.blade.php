<!DOCTYPE html>
<html>
    <head>
        <title>頁面找不到.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

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
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="error-page">
                    <h2 class="headline text-yellow"> 404</h2>

                    <div class="error-content" style="padding-top: 30px">
                        <h3><i class="fa fa-warning text-yellow"></i>  頁面找不到</h3>
                        <p>
                            此時你可以返回 <a href="{{route('admin.index')}}"> 首頁 </a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
