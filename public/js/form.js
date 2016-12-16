console.log('Lectura de esta zona');

// Date from Form input
var $formMain = document.querySelector('#FormMain');
var $URL_DATA = $formMain.dataset.url;
var $boxInfo = document.querySelector('#boxInfo')

// Form DOM Elements
var $btnToSend = document.querySelector('#btnSendForm');
var $txtCodigo = document.querySelector('#txtCodigo');
var $txtDni = document.querySelector('#txtDni');


// Evento click btnToSend
$btnToSend.addEventListener('click', function (e) {
    // input data partner
    var infoPartner = {
        codigo: $txtCodigo.value,
        dni: $txtDni.value
    }

    console.log('Evento Click');

    fromToSend($URL_DATA, infoPartner, 'post', function (result) {
        console.log('DATOS');
        console.log(result);

        document.body.innerHTML = result;

    });

    return false;
})

// Form partner Data
function fromToSend(reqURL, info, method, cb) {
    $.ajax({
         url: reqURL,
         method: method,
         data: info,
         success: function (result) {
             cb(result)
         },
         statusCode: {
            422: function(err) {
                // Limpiando boxInfo
                $boxInfo.innerHTML = '';
                console.log( "error" );

                var messageErrors = err.responseText;
                messageErrors = JSON.parse(messageErrors);

                for(var msg in messageErrors) {
                    var messageError = messageErrors[msg][0];
                    $boxInfo.innerHTML += messageError + '<br>';
                    console.log(messageError);
                }
            }
        }
     })
}

function fromToSend33(reqURL, info, method, cb) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: reqURL,
            method: method,
            data: info,
            success: function (result) {
                cb(result)
            }
        })

        readFile(filename, { enconding: 'utf8' }, function (err, data) {
            if(err) {

                reject(err)

            } else {
                resolve(data)
            }
        })
    })
}

// usanod la promesa

/*readFilePrimisifec(fileName)
    .then(function (text) {
        console.log(text)
    })
    .catch(function (err) {
        console.log(err);
    })*/




