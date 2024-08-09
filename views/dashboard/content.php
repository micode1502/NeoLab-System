<h1>Dashboard</h1>
<!-- <div class="date">
                <input type="date">
            </div> -->
<!--    START OF INSIGHTS    -->
<div class="insights">
    <!--    START OF SALES    -->
    <div class="sales">
        <span class="icon"><i class="fa-solid fa-chart-simple"></i></span>
        <div class="middle">
            <div class="left mid">
                <!--Mostrar prueba-->
                <h3><?php /* echo $totalUsers; */ ?>Promedio de usuarios registrados</h3>
                <h1><?php echo number_format($percentageUser,2); ?>%</h1>
            </div>
            <div class="progress">
                <canvas id="graphic1"></canvas>
                <!-- <svg>
                    <circle cx="38" cy="38" r="36"></circle>
                </svg>
                <div class="number">
                    <p>81%</p>
                </div> -->
            </div>
        </div>
        <small class="text-muted">Últimas 24h</small>
    </div>
    <!--    END OF SALES    -->
    <!--    START OF EXPENSES    -->
    <div class="expenses">
        <span class="icon"><i class="fa-solid fa-chart-bar"></i></span>
        <div class="middle">
            <div class="left mid">
                <h3>Promedio de Visitas totales</h3>
                <h1><?php echo number_format($promVisit,2);?>%</h1>
            </div>
            <div class="progress">
            <canvas id="graphic2"></canvas>
                <!-- <svg>
                    <circle cx="38" cy="38" r="36"></circle>
                </svg>
                <div class="number">
                    <p>62%</p>
                </div> -->
            </div>
        </div>
        <small class="text-muted">Últimas 24h</small>
    </div>
    <!--    END OF EXPENSES    -->
    <!--    START OF INCOME    -->
    <div class="income">
        <span class="icon"><i class="fa-solid fa-arrow-trend-up"></i></span>
        <div class="middle">
            <div class="left">
                <h3>Promedio modificaciones del total de usuarios</h3>
                <h1><?php echo number_format($averageModifications,2); ?>%</h1>
            </div>
            <!-- <div class="progress"> -->
            <!-- <canvas id="graphic3"></canvas> -->
                <!-- <svg>
                    <circle cx="38" cy="38" r="36"></circle>
                </svg>
                <div class="number">
                    <p>44%</p>
                </div> -->
            <!-- </div> -->
        </div>
        <small class="text-muted">Últimas 24h</small>
    </div>
    <!--    END OF INCOME    -->
</div>
<!--    END OF INSIGHTS    -->

<div class="recent-orders">
    <div class="title-table d-flex justify-content-between mb-3">
        <h2>Usuarios Registrados</h2>
    </div>

    <small class="text-muted">Último mes</small>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Correo</th>
                <th>Teléfono</th>
            </tr>
            <tr>
                <td colspan="6" class="pt-3">Información no disponible</td>
            </tr>
        </thead>
        <tbody id="usersTable">
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="<?php echo BASE_URL ?>views/dashboard/js/chartjs.js"></script>
<script>
    $(document).ready(function() {
        requestData();
    });
    
    function requestData(){
        var g1 = document.getElementById("graphic1").getContext("2d");
        var g2 = document.getElementById("graphic2").getContext("2d");
        /* var g3 = document.getElementById("graphic3").getContext("2d"); */
        $.ajax({
            url: "<?php echo BASE_URL ?>administration/data",
            type: "POST",
            success: function(response){
                var jsonData = JSON.parse(response);
                console.log(jsonData);
                function drawChart(ctx, percent = 100, text = '100', color = 'rgba(66,134,244,1', angle = 0){
    
                    /* Centra y muestra el texto al centro */
                    const dLabel = {
                        id: 'dounghnutLabel',
                        beforeDatasetsDraw(chart, args, pluginOptions){
                            const {ctx,data} = chart;
                            ctx.save();
                            const xCoor = chart.getDatasetMeta(0).data[0].x;
                            const yCoor = chart.getDatasetMeta(0).data[0].y;
                            ctx.font = 'bold 10px sans-serif';
                            ctx.fillStyle = 'rgba(54, 164, 235, 1)';
                            ctx.textAlign = 'center';
                            ctx.textBaseLine = 'middle';
                            ctx.fillText(text+'%', xCoor, yCoor);
                        }
                    }
                    /* Dibuja el grafico */
                    var myChart = new Chart(ctx,{
                        type: "doughnut",
                        data: {
                            labels:['col1'],
                            datasets:[{
                                label: ['Num datos'],
                                data:[percent, percent-100],
                                backgroundColor:[
                                    color,
                                    'rgba(66,134,244,0)'
                                ],
                                borderRadius: 1000,
                                borderAlign: 'inner',
                                borderWidth: 4,
                                borderColor: 'rgba(255,255,255,0)',
                                hoverBorderColor: 'rgba(255,255,255,0)',
                                hoverBorderJoinStyle: 'round',
                                hoverBorderDashOffset: 0,
                                hoverBorderDash: [0],
                                hoverOffset: 0,
                            }]
                        },
                        options:{
                    
                            plugins: {
                                legend: {
                                    display: false,
                                    /* position: 'chartArea', */
                                    /* align: 'center', */
                                    labels: {
                                        boxWidth: 0
                                    }
                                },
                                tooltip: {
                                    enabled: false
                                }
                            }
                        },
                        plugins: [dLabel]
                    });
                }

                console.log(jsonData);
                drawChart(g1, jsonData.percentageUser, jsonData.percentageUser);
                drawChart(g2, jsonData.promVis, jsonData.promVis);
                /* drawChart(g3, 2.5, 2.5); */
            }   
        })
    }
    
</script>
<script>
    $(document).ready(function() {
        listUsers();
    });


    function listUsers() {
        $.ajax({
            url: "<?php echo BASE_URL ?>administration/showUsers",
            type: "POST",
            success: function(response) {
                var jsonData = JSON.parse(response);
                let cont = 0;
                filas = "";
                $.each(jsonData.users, function(idx, val) {
                    cont++;

                    filas +=
                        "<tr>" +
                        "<td>" +
                        cont +
                        "</td>" +
                        "<td> <div class='profile-photo text-center'><img src='public/users/" + val.avatar + "' width='50' height='50' class='img-fluid'></div></td>" +
                        "<td>" +
                        val.name +
                        " " +
                        val.lastName +
                        "</td>" +
                        "<td>" +
                        val.dni +
                        "</td>" +
                        "<td>" +
                        val.email +
                        "</td>" +
                        "<td>" +
                        val.number +
                        "</td>" +
                        "</tr>";
                });

                $("#usersTable").html(filas);
            },
        });
    }
</script>
