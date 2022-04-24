<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                background-image: url("{{ asset('/images/Mips-Background.png') }}");
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 25px;
                top: 18px;
            }

            .content {
                text-align: center;
                
            }

            .title {
                font-size: 30px;
            }

            .links > a {
/*                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                */
                padding: 10px 25px;
                letter-spacing: .1rem;
                text-decoration: none;
                font-family: "Montserrat", Sans-serif;
                font-size: 15px;
                font-weight: 600;
                text-transform: uppercase;
                fill: #FFFFFF;
                color: #FFFFFF;
                background-color: #F76501;
                border-radius: 10px 10px 10px 10px;
                        }

            .m-b-md {
                margin-bottom: 30px;
                font-family: "Montserrat", sans-serif;
            }
            .orange{
                color: #f76501;
            }
            .landing-brand-image{
                width: 50%;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">

                <div class="title m-b-md">
                    <strong><span class="orange">PROVIDER ENROLLMENT</span></strong></br>
                    and <strong>CREDENTIALING</strong> services
                </div>
<img src="{{ asset('/images/Credentialing-Slider.png') }}" alt="The Logo" class="landing-brand-image"
            </div>
        </div>
    </body>
</html>
