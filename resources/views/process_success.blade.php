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

            .btnFacebookStyle {
                color: white;
                text-align: center;
                background: #3B5998;
                border: 0;
                padding: .6rem 2rem;
                font-size: .9rem;
                cursor: pointer;
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
                 <div id="container">
	                <h1>Ingresa con Facebook</h1>
	                <div>

                        <button id="btnLoginFacebook" class="btnFacebookStyle">Login Facebook</button>
	                </div>
	              <div id="infoBox">
                    
                  </div>
            	</div>
            </div>
        </div>
    </body>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript">
        $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
        </script>
	    <script>
	       $.ajax({
	         url: '//connect.facebook.net/es_ES/all.js',
	         dataType: 'script',
	         cache: true,
	         success: function() {
	           FB.init({
	             appId: '1194516987303905',
	             xfbml: true
	           });

	             // Evento Click de Boton login con facebook
                 var $btnLoginFacebook = document.querySelector('#btnLoginFacebook');
                 var $boxInfo = document.querySelector('#infoBox');

                 $btnLoginFacebook.addEventListener('click', function () {
                     FB.login(
                         function(response) {
                             if (response.authResponse) {
                                 FB.api('/me?fields=id,name,email,permissions', function(response) {
                                     console.log('Datos del usuario');
                                     console.log(response);

                                     // Proceso de enviar datos al servidor
                                     var dato_user = {
                                         name: response.name,
                                         email: response.email,
                                         avatar: `http://graph.facebook.com/${ response.id }/picture?type=large`,
                                         codigo: '<?= $codigo ?>',
                                         dni: '<?= $dni ?>'
                                     }

                                     console.log('DATOS PARA ENVIAR');
                                     console.log(dato_user);

                                     $.ajax({
                                         url: 'http://dni-test.mambo.lv:8080/api/socio/send-data',
                                         method: 'POST',
                                         data: dato_user,
                                         success: function (result) {
                                             console.log('Respuesta');
                                             console.log(result);

                                             // Validate Error: Email taken
                                             if(result.hasOwnProperty('errors')) {

                                                 // Validation Error Message
                                                 var messageErrors = result.errors;

                                                 console.log(messageErrors);

                                                 for(var msg in messageErrors) {
                                                     messageErrors = messageErrors[msg][0];
                                                     $boxInfo.innerHTML += messageErrors + '<br>';
                                                 }

                                                 $boxInfo.style.paddingTop = '1.5rem';

                                             } else {
                                                 // El proceso se completo con exito
                                                 document.body.innerHTML = result;

                                             }

                                         }
                                     })

                                 });

                             } else {
                                 console.log('User cancelled login or did not fully authorize.');
                             }
                         },
                         {scope:'email'}
                     );
                 })
	         }
	       });

	    </script>
</html>
