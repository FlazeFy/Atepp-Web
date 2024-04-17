<div class="d-flex justify-content-between">
    <h1 class="fw-bold">History</h1>
    <h1 class="fw-bold" id="res_time_avg"></h1>
</div>
<div id="history_holder"></div>

<script>
    let res_time_total = 0

    function get_list_history(id) {
        $('#history_holder').empty()
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/project/response/${id}`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                let data =  response.data

                for(var i = 0; i < data.length; i++){
                    res_time_total = res_time_total + data[i].response_time

                    $('#history_holder').append(`
                        <div class='pt-3 pb-2 text-white'>
                            <span class='bg-success rounded-pill me-1 py-1 px-3'>${data[i].response_method}</span> 
                            <span class='bg-success rounded-pill me-1 py-1 px-3'>${data[i].response_status}</span> 
                            <span class='rounded-pill me-1 py-1 px-3 ${data[i].response_time >= 3000 ? 'bg-danger' : data[i].response_time >= 1000 ? 'bg-warning' : 'bg-success' }'>${data[i].response_time.toFixed(2)} ms</span> 
                            on <b>${data[i].endpoint_name}</b> from ${data[i].response_env} environmnet at ${get_date_to_context(data[i].created_at, 'datetime')}
                            <div class='mt-2'>
                                <button class='btn btn-primary px-2 py-1' style='font-style: underline;' onclick='get_response_body("${data[i].id}")'><i class="fa-solid fa-arrow-right"></i> Response Body</button>
                            </div>
                        </div><hr>`
                    )
                }

                const avg = res_time_total / data.length
                document.getElementById('res_time_avg').innerHTML = `Average Time : ${avg.toFixed(2)} ms`
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
    }

    function get_response_body(id) {
        $('#response_box').empty()
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/project/response/${id}/body`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                $('#response_box').html(response.data.response_body)
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }
</script>