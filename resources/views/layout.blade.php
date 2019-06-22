<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('page_title') {{ env('APP_NAME') }} </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Stylesheet -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" integrity="sha256-BtbhCIbtfeVWGsqxk1vOHEYXS6qcvQvLMZqjtpWUEx8=" crossorigin="anonymous" />
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="container-fluid">
                <div class="row">
                    <h2 class="jumbotron well text-center w-100">{{ env('APP_NAME') }}</h2>
                    <div class="container">
                        @if (Session::has('flash_notification.message'))
                        <div class="alert alert-{{ Session::get('flash_notification.level') }} alert-dismissible fade show">
                            {!! Session::get('flash_notification.message') !!}

                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
