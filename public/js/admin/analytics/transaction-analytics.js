
var data=[];
$.ajax({
    type: "GET",
    url: "/admin/get_transactions_types_count",
    processData: false,
    contentType: false,
    cache: true,
    timeout: 600000,
    success: function (response) {
        data =response
        console.log(data)
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Transactions cc","Transactions cm"],
                datasets: [{
                    label: 'Compare of Total Transactions OverAll Analytics',
                    data: [data['cc'], data['cm']],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',

                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
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


    },
    error: function (e) {
        console.log("ERROR : ", e);
    }
});
