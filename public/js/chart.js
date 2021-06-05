const chart = document.getElementById("chart");
if (chart) {
    const months = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
    ];
    fetch("/chart")
        .then((response) => response.json())
        .then((response) => {
            let array = [];
            for (let i = 0; i < months.length; i++) {
                const found = response.find((item) => item.m - 1 === i);
                if (found)
                    array.push({
                        x: months[found.m - 1],
                        y: found.tickets_count,
                    });
                else array.push({ x: months[i], y: 0 });
            }
            return array;
        })
        .then((data) => {
            renderChart(data);
        });

    function renderChart(data) {
        var timeFormat = "DD/MM/YYYY";
        var config = {
            type: "line",
            data: {
                datasets: [
                    {
                        label: "Tickets creados",
                        data: data,
                        fill: false,
                        borderColor: "#00a4eb"
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    xAxes: [
                        {
                            type: "time",
                            time: {
                                format: timeFormat,
                                tooltipFormat: "ll",
                            },
                            scaleLabel: {
                                display: true,
                                labelString: "Date",
                            },
                        },
                    ],
                    yAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: "value",
                            },
                        },
                    ],
                },
            },
        };
        new Chart(chart, config);
    }
}
