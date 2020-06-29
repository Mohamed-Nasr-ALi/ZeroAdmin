var data=[];
$.ajax({
    type: "GET",
    url: "/admin/get_total",
    processData: false,
    contentType: false,
    cache: true,
    timeout: 600000,
    success: function (response) {
        data =response
        var ctxP = document.getElementById("labelChart").getContext('2d');
        var myPieChart = new Chart(ctxP, {
            plugins: [ChartDataLabels],
            type: 'pie',
            data: {
                labels: ["Total Agents", "Total Customers", "Total Transactions"],
                datasets: [{
                    data: [data['agents_count'],data['customers_count'],data['transactions_count']],
                    backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870"]
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right',
                    labels: {
                        padding: 20,
                        boxWidth: 10
                    }
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            return value;
                        },
                        color: 'white',
                        labels: {
                            title: {
                                font: {
                                    size: '16'
                                }
                            }
                        }
                    }
                }
            }
        });


    },
    error: function (e) {
        console.log("ERROR : ", e);
    }
});
