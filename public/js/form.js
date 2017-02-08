(function () {

function formEvent() {

    // Date from Form input
    var $formMain = document.querySelector('#FormMain');
    var $URL_DATA = $formMain.dataset.url;
    var $boxInfo = document.querySelector('#boxInfo');

    // Form DOM Elements
    var $btnToSend = document.querySelector('#btnSendForm');
    var $txtCodigo = document.querySelector('#txtCodigo');
    var $txtDni = document.querySelector('#txtDni');
    var $btnCheck = document.querySelector('#btnCheck');
    var $btnTerminosCondiciones = document.querySelector('#btnTerminosCondiciones');

    // Promise to Partner
    function fromToSend(reqURL, info, method) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: reqURL,
                method: method,
                data: info,
                success: function (result) {
                    resolve(result)
                },
                statusCode: {
                    422: function(err) {
                        reject(err)
                    }
                }
            })
        })
    }

    // Modal de image
    function modalBox(contentTermsConditionHTML) {
        console.log('Terms and Conditions!!');
        console.log(contentTermsConditionHTML);

        // Get the modal
        var modal = document.getElementById('myModal');
        var modalContent = document.getElementById('myModalContent');

        modal.style.display = "block";

        // Insert Terms and Conditions
        modalContent.innerHTML = '';
        modalContent.innerHTML += contentTermsConditionHTML;

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    }

    // Event click btnToSend
    $btnToSend.addEventListener('click', function (e) {
        // input data partner
        var infoPartner = {
            dni: $txtDni.value
        }

       var $inputDoc = document.querySelector('#txtDni');

        if($inputDoc.value !== '' &&
           $inputDoc.value.length < 13) {

            var $btnCheck2 = document.querySelector('#btnCheck');

            console.log('campo error paso todos');

            // Evaluate input check
            if($btnCheck2.checked === true) {
                // CheckBox is true
                console.log('check');

                // Evaluate Event from ajax
                fromToSend($URL_DATA, infoPartner, 'post')
                    .then(function (result) {
                        console.log(result);
                        var template = '';
                        var message = '';

                        var $contentBox = document.querySelector('#contentBox');

                        if(result.hasOwnProperty('message')) {

                            if(result.message === 'user_registed') {

                                message = 'Tu ya eres parte';

                            }

                            template = `<div>
                                            <h2>
                                                !${ message }¡
                                            </h2>
                                            <p>Revisa tu Facebook. Dentro de poco te llegará una solicitud de amistad <br> ¡Acéptala y prepárate para lo que viene!</p>
                                        </div>`;

                            $contentBox.innerHTML = template;

                        } else {

                            template = `<div class="content">
                                                 <div id="container">
                                                    <h1>Ingresa con Facebook</h1>
                                                    <div>

                                                        <button id="btnLoginFacebook" class="btnFacebookStyle">Login Facebook</button>
                                                    </div>
                                                  <div id="infoBox">
                                                    
                                                  </div>
                                                </div>
                                            </div>`;

                            $contentBox.innerHTML = template;

                             console.log('lectura para FACEBOOK');
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
                                                             dni: result.dni
                                                         }

                                                         console.log('DATOS PARA ENVIAR');
                                                         console.log(dato_user);

                                                         // mostrando datos al usuario
                                                         $contentBox.innerHTML = 'Enviando...';

                                                         // Enviando datos obtenidos la db
                                                         $.ajax({
                                                             url: '/api/socio/send-data',
                                                             method: 'POST',
                                                             data: dato_user,
                                                             success: function (result) {
                                                                 console.log('Respuesta ==>');
                                                                 console.log(result);

                                                                 // Validate Error: Email taken
                                                                 if(result.hasOwnProperty('errors')) {

                                                                     // Validation Error Message
                                                                     var messageErrors = result.errors;

                                                                     console.log();
                                                                     $contentBox.innerHTML = '';



                                                                     if( messageErrors.email[0] !== undefined ) {

                                                                        message = 'Esta cuenta de facebook, ya fue registrada';

                                                                     }

                                                                     template = `<div>
                                                                                     <h2>
                                                                                         !${ message }¡
                                                                                     </h2>
                                                                                     <p>Porfavor, intenta nuevamente con tu cuenta personal</p>
                                                                                 </div>`;

                                                                     $contentBox.innerHTML = template;

                                                                     // $boxInfo.style.paddingTop = '1.5rem';

                                                                 } else {
                                                                     // El proceso se completo con exito
                                                                     $contentBox.innerHTML = `<div>
                                                                                                   <h2>¡Gracias por unirte!</h2>
                                                                                                   <p>Revisa tu Facebook. Dentro de poco te llegará una solicitud de amistad</p>
                                                                                                   <p>¡Acéptala y prepárate para lo que viene!</p>
                                                                                              </div>`;

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

                        }


                    })
                    .catch(function (err) {

                        // Limpiando boxInfo
                        $boxInfo.innerHTML = '';
                        console.log( "error" );
                        console.log(err);

                        var msg = '';

                        if(err.status === 422) {
                            msg = 'El número de documento, no fue encontrado'

                        } else {

                            msg = 'Error en procesar tu numero de documento'
                        }

                        $inputDoc.style.border = '1px solid #ec3425';

                        $boxInfo.style.display = 'block';

                        // Evaluate input box
                        $boxInfo.innerHTML = msg;

                    })

            } else {
                console.log('no check');

                var $boxInfo1 = document.querySelector('#boxInfo')

               $inputDoc.style.border = '1px solid #ec3425';

                // CheckBox is false
                $boxInfo1.style.display = 'block';
                $boxInfo1.innerHTML = '';
                $boxInfo1.innerHTML = 'Necesitas Aceptar los terminos y condiciones';

            }

        } else {

            console.log('campo error');


            var $inputDoc1 = document.querySelector('#txtDni');

            var msg = '';

            // Messages erros
            if($inputDoc.value === '') {
                msg = 'El campo documento es obligatorio';

            } else if ($inputDoc.value.length < 12) {
                msg = 'El campo documento debe tener almenos 12 digitos';

            } else {
                msg = 'El campo documento es obligatorio';
            }

            $inputDoc1.style.border = '1px solid #ec3425';

            // CheckBox is false
            $boxInfo.innerHTML = '';
            $boxInfo.innerHTML = msg;
        }

    })

    // Event click btnTerminosCondiciones
    $btnTerminosCondiciones.addEventListener('click', function (e) {

        // Get TermsCondicion.html
        $.ajax({
            url: 'http://dni-test.mambo.lv:8080/terminos_condiciones/index.html',
            method: 'get',
            success: function (result) {
                modalBox(result);
            }
        });
    })
}

function validationTypeFrom() {

    var $inputDoc = document.querySelector('#txtDni');
    var $msgBoxFrom = document.querySelector('#boxInfo');
    
    $msgBoxFrom.innerHTML = '';

    var msg = '';

    $msgBoxFrom.style.color = '#ec3425';

    $('#txtDni').on('input', function() { 

        var numberLimit = 12;

        $inputDoc.style.borderColor = '#dedede';

        if($inputDoc.value.length >= numberLimit) {
            $inputDoc.value = $inputDoc.value.slice(0,numberLimit); 
            $msgBoxFrom.style.display = 'none';
        }

        if($inputDoc.value.length < numberLimit) {

            msg = `El campo documento debe tener ${ numberLimit } digitos`;
            $inputDoc.style.borderColor = '#ec3425';

            $msgBoxFrom.style.display = 'block';
            $msgBoxFrom.innerHTML = msg;
        }

        // Validation only number
        var word = $inputDoc.value;

        if(parseInt(word[word.length - 1]) >= 0 === false) {

            word = word.replace(word[word.length - 1],'');

        }

        $inputDoc.value = word;

    });
    
}

function Main() {
    formEvent();
    validationTypeFrom();
}

window.onload = Main()

})();

