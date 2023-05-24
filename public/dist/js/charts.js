livewire.on('cargarTablaVisitantes', function() {
    console.log('data');
    cargarTablaVisitantes();
});

const vistaVisitantes = document.getElementById('visitantes-chart');

function cargarTablaVisitantes() {
    const tablaVisitantes = new Chart(vistaVisitantes, {
        type: 'line',
        data: {
            labels: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
            datasets: [
            {
                label: 'Visitantes',
                data: [12, 19, 3, 5, 2, 3, 10],
                fill:false,
                borderColor: '#fbc658',
                borderWidth: 3
            },
            {
                label: 'Visitantes 2',
                data: [16, 13, 6, 3, 9, 30, 12],
                fill: false,
                borderColor: '#4bc0c0',
                borderWidth: 3
            },
        ]
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
