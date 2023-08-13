// Escucha cuando el documento este cargado todo HMTL CSS

// const { eventNames } = require("gulp");

document.addEventListener('DOMContentLoaded', function () {

  // eventListeners();

  // darkMode();

  // desactivarenlaces();
  // animacion();
  // darkmode2();
  tabs();

  formulariocliente();

  // btnperfil();
});

//    Leyendo las preferencias del sistema para ver si tiene modo oscuro o claro
const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

function darkMode() {


  //  console.log(prefiereDarkMode.matches);

  // console.log(prefiereDarkMode.matches);
  if (prefiereDarkMode.matches) {
    document.body.classList.add('dark-mode');
    document.querySelector('.dark-mode-boton').style.display = '';
    document.querySelector('.day').style.display = 'none';

  } else {
    document.body.classList.remove('dark-mode');
    document.querySelector('.dark-mode-boton').style.display = 'none';
    document.querySelector('.day').style.display = '';

  }

  prefiereDarkMode.addEventListener('change', function () {
    if (prefiereDarkMode.matches) {
      document.body.classList.add('dark-mode');
      document.querySelector('.dark-mode-boton').style.display = '';
      document.querySelector('.day').style.display = 'none';

    } else {
      document.body.classList.remove('dark-mode');
      document.querySelector('.dark-mode-boton').style.display = 'none';
      document.querySelector('.day').style.display = '';

    }
  });

  const botonDarkMode = document.querySelector('.dark-mode-boton');
  botonDarkMode.addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');
    document.querySelector('.dark-mode-boton').style.display = 'none';
    document.querySelector('.day').style.display = '';

  });

  const botonDayMode = document.querySelector('.day');
  botonDayMode.addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');
    document.querySelector('.dark-mode-boton').style.display = '';
    document.querySelector('.day').style.display = 'none';
  });

}

function darkmode2() {

  if (prefiereDarkMode.matches) {
    document.body.classList.add('dark-mode');
    document.querySelector('.dark-mode-boton2').style.display = '';
    document.querySelector('.day2').style.display = 'none';

  } else {
    document.body.classList.remove('dark-mode');
    document.querySelector('.dark-mode-boton2').style.display = 'none';
    document.querySelector('.day2').style.display = '';

  }


  const botonDarkMode = document.querySelector('.dark-mode-boton2');
  botonDarkMode.addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');
    document.querySelector('.dark-mode-boton2').style.display = 'none';
    document.querySelector('.day2').style.display = '';

  });

  const botonDayMode = document.querySelector('.day2');
  botonDayMode.addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');
    document.querySelector('.dark-mode-boton2').style.display = '';
    document.querySelector('.day2').style.display = 'none';
  });
}

// CUANDO ESTE CARGADO EL DOCUMENTO CARGADO SE EJECUTA
function eventListeners() {
  // Seleccionamos la clase 
  const mobileMenu = document.querySelector('.mobile-menu');
  // Le agregamos el evento de click le asigno la funcion
  mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
  // Seleccionamos el menu 
  const navegacion = document.querySelector('.navegacion');
  // El toggle si la tiene la quita y si no la agrega
  navegacion.classList.toggle('mostrar')
}

function desactivarenlaces() {
  var enlances = document.querySelectorAll("#preventD");
  enlances.forEach(element => {
    console.log(element);
    element.addEventListener("click", function (evento) {
      evento.preventDefault();
    });
  });

}

function tabs() {
  // $('ul.tabs li:first a:eq(1)').addClass('active');
  // $('.secciones article').hide();
  // $('.secciones article:first').show();

  $('ul.tabs li a:first').addClass('active');
  $('.secciones article').hide();
  $('.secciones article:first').show();

  $('ul.tabs li a').click(function () {
    $('ul.tabs li a').removeClass('active');
    $(this).addClass('active');
    $('.secciones article').hide();

    var activeTab = $(this).attr('href');
    $(activeTab).show();
    return false;

  })
}

  function formulariocliente(){
    const Provincia = document.getElementById("Provincia");
    const Canton = document.getElementById("Canton");
    const Distrito = document.getElementById("Distrito");
        //Cargar el Combo de Provincias
        var parametros = {
            "codigoCrud": 4
        };
        $.ajax({
            data: parametros,
            url: 'funcionesphp/crud_clientes.php',
            type: 'POST',
            dataType: 'json',
            success: function(mensaje) {

                mensaje.forEach(item => {
                    const newOption = new Option(item.Nombre_Provincia, item.Codigo_Provincia);
                    Provincia.appendChild(newOption);
                });
             

            },
            Error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: textStatus & errorThrown,

                })
            }

        });

        Provincia.addEventListener("change", function() {
            const codigoprovincia = Provincia.value;
            Canton.length = 1;
            console.log(codigoprovincia);
            var parametros = {
                "codigoCrud": 5,
                "codigoProvincia": codigoprovincia
            };
            $.ajax({
                data: parametros,
                url: 'funcionesphp/crud_clientes.php',
                type: 'POST',
                dataType: 'json',
                success: function(mensaje) {
                    console.log(mensaje);
                    mensaje.forEach(item => {
                        const newOption = new Option(item.Nombre_Canton, item.Codigo_Canton);
                        Canton.appendChild(newOption);
                    });
                

                },
                Error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: textStatus & errorThrown,

                    })
                }
            });
        });


        const formulario = document.querySelector('.formulario_nuevocliente');
        const nombreInput = formulario.querySelector('[name="nombre"]');

        formulario.addEventListener("submit", function(event) {
            if (!validarNombre(nombreInput.value)) {
                alert("Por favor, ingresa un nombre válido.");
                event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarEmail(emailInput.value)) {
                alert("Por favor, ingresa un correo electrónico válido.");
                event.preventDefault(); // Evita el envío del formulario
                return;
            }

            // Si pasa todas las validaciones, el formulario se enviará
        });

        function validarNombre(nombre) {
            // Realiza tus validaciones aquí, devuelve true si es válido
            return nombre.trim() !== "";
        }

        function validarEmail(email) {
            // Realiza tus validaciones aquí, devuelve true si es válido
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
  
  }


// function btnperfil() {
//   var id = document.querySelector('#id_usuario').innerText;
//   console.log(id);
//   // window.location = 'perfilusuariodescubrir.php';
//   window.location = `perfilusuariodescubrir.php?id=${id}`;
// }

