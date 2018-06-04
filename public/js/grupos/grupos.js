$(document).ready(function () {
  let dataGroup;

  $('.modal').modal({
    startingTop: '0%',
    endingTop: '2%'
  });

  $('.modalGraficaGrupo').click(function(){
    let $this = $(this);
    dataGroup = $this.data('graphic-data');
    labelsG = $this.data('graphic-labels');
    // console.log(dataGroup);
    crearGrafica(dataGroup, labelsG, 'graficaGrupo');
    // $('canvas').width('60%');
    // $('canvas').height('60%');
  });

  $('.modalGraficaAlumno').click(function () {
    let $this = $(this);
    dataGroup = $this.data('graphic-data');
    labelsG = $this.data('graphic-labels');
    console.log(dataGroup);
    crearGrafica(dataGroup, labelsG, 'graficaAlumno');
    // $('canvas').width('60%');
    // $('canvas').height('60%');
  });
  
});//Termina document ready

// let ctx;

function crearGrafica(dataG, labelsG, elemento){
  // let ctx = ctx.clearRect(0, 0, canvas.width, canvas.height);
  // ctx.update();
  ctx = document.getElementById(elemento).getContext('2d');
  var groupChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labelsG,
      datasets: [{
        label: '# of Votes',
        data: dataG,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
}