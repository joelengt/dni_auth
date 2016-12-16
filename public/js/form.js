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

    // Evento click btnToSend
    $btnToSend.addEventListener('click', function (e) {
        // input data partner
        var infoPartner = {
            codigo: $txtCodigo.value,
            dni: $txtDni.value
        }

        // Evaluate input check
        if($btnCheck.checked === true) {
            console.log(true);

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

                    // Print Message erros
                    for(var msg in messageErrors) {
                        var messageError = messageErrors[msg][0];
                        $boxInfo.innerHTML += messageError + '<br>';
                        console.log(messageError);
                    }
                })

        } else {
            console.log(false);
            $boxInfo.innerHTML = '';
            $boxInfo.innerHTML += 'Necesitas Aceptar los terminos y condiciones';
        }

    })

}

function Main() {
    console.log('H')
    formEvent()
}

window.onload = Main()

})();

