<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/footer.css') }}" rel="stylesheet" type="text/css">

</head>
<body>

    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Laravel5</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                   <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li> -->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="./">Login</a></li>
                    <li><a href="./">Register</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>

    <div id="footer">
        <div class="container">
            <p class="text-muted">&copy; VK 2016</p>
        </div>
    </div>

</div>
</body>
</html>