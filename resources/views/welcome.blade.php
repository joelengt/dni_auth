<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{!! csrf_token() !!}"/>

        <link rel="icon" type="image/png" href="./images/logo-favicon-32x32.png">

        <title>#ConTottus</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="./css/modal/index.css">
        
        <!-- Styles -->
        <link rel="stylesheet" href="./css/app.css">

    </head>
    <body>
        <section class="ContentForm">
            <div class="ContentFormBox">
                <div class="ContentFormBox__content">
                    <div class="ContentFormBox__tittle">
                        <div class="ContentFormBox__logo">
                            <img src="./images/logo-contottus-260x173 (2).jpg">
                        </div>
                        <div>
                            <h2>
                                TOTTUS QUIEBRA
                            </h2>
                            <p>
                               Las bareras entre los colaboradores.<br>
                               ¡Sé parte del cambio!
                            </p>
                        </div>
                    </div>
                    <div class="ContentFormBox__form">
                        <div class="content" id="contentBox">
                            <form id="FormMain" data-url="{{ route('validate.user') }}" class="FormMain">
                                <div class="FormMain__content">
                                    <div class="FormMain__title">
                                        <p>Ingresa tus Datos</p>
                                    </div>
                                    <div class="FormMain__content--box-inputs">
                                        <div class="FormMain__content--dni">
                                            <div class="FormMain__content--codigo__label">
                                                <label for="#">Número Documento</label>
                                            </div>
                                            <div class="FormMain__content--codigo__input">
                                                <input type="text" name="dni" id="txtDni" class="inputTextStyle  inputTextStyle--codigo-helper" placeholder="Ingresa tu numero de documento">
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
                                    <div id="boxInfo" style="padding-top: 1rem; text-align: left;"></div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- The Modal -->
        <div id="myModal" class="modal">
            <!-- The Close Button -->
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
