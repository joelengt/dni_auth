(function () {

function formEvent() {

    // Date from Form input
    var $formMain = document.querySelector('#FormMain');
    var $URL_DATA = $formMain.dataset.url;
    var $boxInfo = document.querySelector('#boxInfo')

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


        // Evaluate input check
        if($btnCheck.checked === true) {
            // CheckBox is true

            // Evaluate Event from ajax
            fromToSend($URL_DATA, infoPartner, 'post')
                .then(function (result) {
                    console.log(result);

                    var $contentBox = document.querySelector('#contentBox');

                    if(result.hasOwnProperty('message')) {

                        $contentBox.innerHTML += result.message + '<br>';

                    } else {

                        var template = `<div class="content">
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

                                                                 console.log(messageErrors);
                                                                 $contentBox.innerHTML = '';

                                                                 for(var msg in messageErrors) {
                                                                     messageErrors = messageErrors[msg];
                                                                     $contentBox.innerHTML += messageErrors + '<br>';
                                                                 }

                                                                 // $boxInfo.style.paddingTop = '1.5rem';

                                                             } else {
                                                                 // El proceso se completo con exito
                                                                 $contentBox.innerHTML = `<div>
                                                                                               <p>Felicidades ${ result.name }</p>
                                                                                               <img src="${ result.avatar }">
                                                                                               <h3>${ result.message }</h3>
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



                    var messageErrors = err.responseText;
                    messageErrors = JSON.parse(messageErrors);

                    // Reset border input box
                    $txtCodigo.style.border = '1px solid #dfdfdf';
                    $txtDni.style.border = '1px solid #dfdfdf';

                    console.log(infoPartner.dni.length);

                    // Print Message erros
                    for(var msg in messageErrors) {
                        var messageError = messageErrors[msg][0];

                        // Evaluate input box
                        if(messageError === 'El campo codigo es requerido.' || messageError === 'El campo codigo no es valido.') {
                            $txtCodigo.style.border = '1px solid #f91f1f';
                        }

                        if (messageError === 'El campo dni es requerido.' || messageError === 'El campo dni no es valido.') {
                            $txtDni.style.border = '1px solid #f91f1f';
                        }

                        $boxInfo.innerHTML += messageError + '<br>';

                    }

                    if(infoPartner.dni.length < 8  || infoPartner.dni.length > 8) {
                        $txtDni.style.border = '1px solid #f91f1f';
                        $boxInfo.innerHTML += 'El campo dni debe tener 8 digitos. <br>';
                    }

                })

        } else {
            // CheckBox is false
            $boxInfo.innerHTML = '';
            $boxInfo.innerHTML += 'Necesitas Aceptar los terminos y condiciones';
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

function Main() {
    console.log('H');
    formEvent()
}

window.onload = Main()

})();

