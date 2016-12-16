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
            codigo: $txtCodigo.value,
            dni: $txtDni.value
        }


        // Evaluate input check
        if($btnCheck.checked === true) {
            // CheckBox is true

            // Evaluate Event from ajax
            fromToSend($URL_DATA, infoPartner, 'post')
                .then(function (result) {
                    console.log(result);
                    document.body.innerHTML = result;
                })
                .catch(function (err) {
                    // Limpiando boxInfo
                    $boxInfo.innerHTML = '';
                    console.log( "error" );

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

