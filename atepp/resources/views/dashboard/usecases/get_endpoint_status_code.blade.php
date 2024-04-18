<div class="text-center mt-3">
    <div id="Stacked_stats_status_code_msg"></div>
    <div id="Stacked_stats_status_code"></div>
</div>

<script type="text/javascript">
    get_stats_status_code()
    function get_stats_status_code() {
        const methods = ['GET','POST','PUT','DELETE','PATCH','HEAD','OPTIONS']
        $.ajax({
                url: "http://127.0.0.1:8000/api/v1/stats/response/status_code",
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                let data =  response.data
                document.getElementById('Stacked_stats_status_code_msg').innerHTML = `
                    <h1 class="fw-bold text-center mb-3" style="font-size:var(--textJumbo) !important;">Response Status Code</h1>
                `

                var options = {
                    series: [
                    {
                        name: 'Informational (100)',
                        data: methods.map(mt => split_status_code(data, mt, 100))
                    },
                    {
                        name: 'Successful (200)',
                        data: methods.map(mt => split_status_code(data, mt, 200))
                    },
                    {
                        name: 'Redirection (300)',
                        data: methods.map(mt => split_status_code(data, mt, 300))
                    },
                    {
                        name: 'Client Error (400)',
                        data: methods.map(mt => split_status_code(data, mt, 400))
                    },
                    {
                        name: 'Server Error (500)',
                        data: methods.map(mt => split_status_code(data, mt, 500))
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    stackType: '100%'
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    },
                },
                xaxis: {
                    categories: methods,
                },
                tooltip: {
                    y: {
                    formatter: function (val) {
                        return val + " Response"
                    }
                    }
                },
                fill: {
                    opacity: 1
                
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetX: 40
                }
                };

                var chart = new ApexCharts(document.querySelector("#Stacked_stats_status_code"), options)
                chart.render()
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
    }

    function split_status_code(arr, method, status){
        res = 0

        arr.forEach(el => {
            if(el.response_method == method && el.response_general_status == status){
                res = el.total
                return
            }
        });

        return res
    }
</script>