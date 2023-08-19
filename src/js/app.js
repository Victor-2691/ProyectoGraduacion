// Escucha cuando el documento este cargado todo HMTL CSS

// const { eventNames } = require("gulp");

document.addEventListener('DOMContentLoaded', function () {

  // eventListeners();

  // darkMode();

  // desactivarenlaces();
  // animacion();
  // darkmode2();
  tabs();



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

function navegacion(){
  const opciones = document.querySelectorAll(".navegacion a");
 console.log(opciones);
  opciones.forEach(opcion => {
    opcion.addEventListener("click", function(event) {
      const target = this.getAttribute("data-target");
      const targetElement = document.getElementById(target);
      
      if (targetElement) {
        opciones.forEach(op => op.classList.remove("activa"));
        this.classList.add("activa");
      }
    });
  });
}


// function btnperfil() {
//   var id = document.querySelector('#id_usuario').innerText;
//   console.log(id);
//   // window.location = 'perfilusuariodescubrir.php';
//   window.location = `perfilusuariodescubrir.php?id=${id}`;
// }

