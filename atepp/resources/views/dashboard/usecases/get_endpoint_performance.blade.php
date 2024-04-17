<h1 class="fw-bold text-center mb-3" style="font-size:var(--textJumbo) !important;">Response Time Taken</h1>
<div class="row">
    <div class="col">
        <button class="btn btn-primary w-100 py-4">
            <h1 class="fw-bold" style="font-size:calc(var(--textXJumbo)*2) !important;" id="total_res_Fast">0</h1> 
            <h2 class="mb-3">Fast Response</h2>
            <span class="bg-success rounded-pill px-3 py-1 fw-bold" style="font-size:var(--textXMD) !important;">About < 1000 ms</span>
        </button>
    </div>
    <div class="col">
        <button class="btn btn-primary w-100 py-4">
            <h1 class="fw-bold" style="font-size:calc(var(--textXJumbo)*2) !important;" id="total_res_Normal">0</h1> 
            <h2 class="mb-3">Medium Response</h2>
            <span class="bg-warning rounded-pill px-3 py-1 fw-bold" style="font-size:var(--textXMD) !important;">1000 ms < Val < 3000 ms</span>
        </button>
    </div>
    <div class="col">
        <button class="btn btn-primary w-100 py-4">
            <h1 class="fw-bold" style="font-size:calc(var(--textXJumbo)*2) !important;" id="total_res_Slow">0</h1> 
            <h2 class="mb-3">Slow Response</h2>
            <span class="bg-danger rounded-pill px-3 py-1 fw-bold" style="font-size:var(--textXMD) !important;">About > 3000 ms</span>
        </button>
    </div>
</div>

<script>
    get_stats_perf()
    function get_stats_perf() {
        $.ajax({
                url: "http://127.0.0.1:8000/api/v1/stats/response/performance",
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                let data =  response.data

                for(var i = 0; i < data.length; i++){
                    document.getElementById(`total_res_${data[i].context}`).innerHTML = data[i].total
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }
</script>