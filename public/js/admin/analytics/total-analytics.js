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
        //doughnut
        var ctxD = document.getElementById("doughnutChart").getContext('2d');
        var myLineChart = new Chart(ctxD, {
            type: 'doughnut',
            data: {
                labels: [`Total Agents: ${data['agents_count']}`, `Total Customers: ${data['customers_count']}`, `Total Transactions: ${data['transactions_count']}`],
                datasets: [{
                    data: [data['agents_count'],data['customers_count'],data['transactions_count']],
                    backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5"]
                }]
            },
            options: {
                responsive: true
            }
        });


    },
    error: function (e) {
        console.log("ERROR : ", e);
    }
});
