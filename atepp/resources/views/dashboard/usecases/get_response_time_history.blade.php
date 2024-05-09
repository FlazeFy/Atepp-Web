<div class="text-center mt-3">
    <div id="Line_stats_response_time_history_msg"></div>
    <div id="Line_stats_response_time_history"></div>
</div>

<script>
    get_stats_status_code()
    function get_stats_status_code() {
        const methods = ['GET','POST','PUT','DELETE','PATCH','HEAD','OPTIONS']
        $.ajax({
            url: "http://127.0.0.1:8000/api/v1/stats/response/time_history",
            datatype: "json",
            type: "get",
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");
                
            }
        })
        .done(function (response) {
            let data =  response.data
            document.getElementById('Line_stats_response_time_history_msg').innerHTML = `
                <h1 class="fw-bold text-center mb-3" style="font-size:var(--textJumbo) !important;">Response Time History</h1>
            `

            var options = {
                series: [
                    {
                        name: "GET",
                        data: data.filter(el => el.response_method === "GET").map(el => el.response_time)
                    },
                    {
                        name: "POST",
                        data: data.filter(el => el.response_method === "POST").map(el => el.response_time)
                    },
                    {
                        name: "PUT",
                        data: data.filter(el => el.response_method === "PUT").map(el => el.response_time)
                    },
                    {
                        name: "DELETE",
                        data: data.filter(el => el.response_method === "DELETE").map(el => el.response_time)
                    },
                    {
                        name: "PATCH",
                        data: data.filter(el => el.response_method === "PATCH").map(el => el.response_time)
                    },
                    {
                        name: "HEAD",
                        data: data.filter(el => el.response_method === "HEAD").map(el => el.response_time)
                    },
                    {
                        name: "OPTIONS",
                        data: data.filter(el => el.response_method === "OPTIONS").map(el => el.response_time)
                    },
                ],

                chart: {
                    height: 350,
                    type: 'line',
                    dropShadow: {
                    enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#77B6EA', '#545454'],
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    borderColor: '#e7e7e7',
                },
                markers: {
                    size: 1
                },
                xaxis: {
                    categories: data.map(el => el.created_at),
                    title: {
                        text: 'Date'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Millisecond'
                    },
                    min: 5,
                    max: 40
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    floating: true,
                    offsetY: -25,
                    offsetX: -5
                }
                };

                var chart = new ApexCharts(document.querySelector("#Line_stats_response_time_history"), options);
                chart.render();
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            // Do someting
            });
    }
</script>