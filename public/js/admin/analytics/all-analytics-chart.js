

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
        console.log(data)
        new Chart(document.getElementById("horizontalBar"), {
            "type": "horizontalBar",
            "data": {
                "labels": ["Requests","Agent", "Customer", "Transactions", "CC Transactions", "CM Transactions"],
                "datasets": [{
                    "label": "My First Dataset",
                    "data": [data['requests_count'],data['agents_count'],data['customers_count'],data['transactions_count'],data['cc_count'],data['cm_count']],
                    "fill": false,
                    "backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)",
                        "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)",
                        "rgba(153, 102, 255, 0.2)"
                    ],
                    "borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)",
                        "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)"
                    ],
                    "borderWidth": 1
                }]
            },
            "options": {
                "scales": {
                    "xAxes": [{
                        "ticks": {
                            "beginAtZero": true
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
