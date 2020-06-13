<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <div class="container" style="max-width: inherit">
                <navbar-component></navbar-component>
                <post :auth_user_id='@json(Auth::id())'></post>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            $(document).ready(function()
            {
                $(document).bind('cut copy paste',function(e){
                    e.preventDefault();
                });

                $(document).on('contextmenu',function(e){
                    return false;
                })
            });
        </script>
    </body>
</html>
