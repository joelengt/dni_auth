<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./css/modal/index.css">
        <link rel="stylesheet" href="./css/form/index.css">
        
        <!-- Styles -->

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif


            <div class="content" id="contentBox">
                <div>
                    <form id="FormMain" data-url="{{ route('validate.user') }}" class="FormMain">
                        <div class="FormMain__title">
                            <h2>Validar usuario</h2>
                        </div>
                        <div class="FormMain__content">
                            <div class="FormMain__content--box-inputs">
                                <div class="FormMain__content--codigo">
                                    <div class="FormMain__content--codigo__label">
                                        <label for="#">Codigo</label>
                                    </div>
                                    <div class="FormMain__content--codigo__input">
                                        <input type="text" name="codigo" id="txtCodigo" class="inputTextStyle">
                                    </div>
                                </div>
                                <div class="FormMain__content--dni">
                                    <div class="FormMain__content--codigo__label">
                                        <label for="#">DNI</label>
                                    </div>
                                    <div class="FormMain__content--codigo__input">
                                        <input type="text" name="dni" id="txtDni" class="inputTextStyle  inputTextStyle--codigo-helper">
                                    </div>
                                </div>
                            </div>
                            <div class="FormMain__content--TermsConditions  FormValidate">
                                <div class="FormValidate__terminos-condiciones">
                                    <div class="FormValidate__terminos-condiciones--checkbox">
                                        <input type="checkbox" id="btnCheck">
                                    </div>
                                    <div class="FormValidate__terminos-condiciones--text">Acepto los <a href="#" id="btnTerminosCondiciones">Terminos y condiciones</a></div>
                                </div>
                                <div class="FormValidate__btn-submit">
                                    <div id="btnSendForm" class="btnSendForm">Enviar</div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id="boxInfo"></div>
                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif

                </div>
            </div>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">
            <!-- The Close Button -->
            <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
            <div id="myModalContent"></div>
        </div>

        <script type="text/javascript" src="./js/jquery-2.2.4.js"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
        </script>
        <script type="text/javascript" src="./js/form.js"></script>
    </body>
</html>
