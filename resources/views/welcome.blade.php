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
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            /* Form Validate */
            .FormValidate {
                text-align: center;
            }
            .FormValidate__terminos-condiciones {
                display: block;
                padding-top: 1rem;
            }
            .FormValidate__terminos-condiciones--checkbox {
                display: inline-block;
            }

            .FormValidate__terminos-condiciones--text {
                display: inline-block;
            }

            .FormValidate__btn-submit {
                display: block;
                padding-top: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif



            <div class="content">
                <div>
                    <form action="{{ route('validate.user') }}" method="POST">
                        {{ csrf_field() }}
                        <div>
                            <h2>Validar usuario</h2>
                        </div>
                        <div>
                            <div>
                                <label for="#">Codigo</label>
                            </div>
                            <div>
                                <input type="text" name="codigo">
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="#">DNI</label>
                            </div>
                            <div>
                                <input type="text" name="dni">
                            </div>
                        </div>
                        <div class="FormValidate">
                            <div class="FormValidate__terminos-condiciones">
                                <div class="FormValidate__terminos-condiciones--checkbox">
                                    <input type="checkbox">
                                </div>
                                <div class="FormValidate__terminos-condiciones--text">Aceto los <a href="#">Terminos y condiciones</a></div>
                            </div>
                            <div class="FormValidate__btn-submit">
                                <button id="btnSendForm">Enviar</button>
                            </div>
                        </div>
                    </form>

                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif

                </div>
            </div>
        </div>
    </body>
</html>
