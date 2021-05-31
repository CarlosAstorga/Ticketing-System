const chart = document.getElementById("chart");
if (chart) {
    const { open, solving, pending, solved, closed } = chart.dataset;

    const data = {
        labels: ["Abierto", "En proceso", "Pendiente", "Resuelto", "Cerrado"],
        datasets: [
            {
                label: "Tickets por estatus",
                data: [open, solving, pending, solved, closed],
                backgroundColor: [
                    "#424548",
                    "#ffca2b",
                    "#e15360",
                    "#31d2f2",
                    "#fa935e",
                ],
                hoverOffset: 4,
            },
        ],
    };

    const config = {
        type: "doughnut",
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Tickets por estatus",
                },
            },
        },
    };

    new Chart(chart, config);
}
