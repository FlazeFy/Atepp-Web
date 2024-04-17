<div id="history_holder"></div>

<script>
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
                    $('#history_holder').append(`
                        <div class='pt-3 pb-2 text-white'>
                            <span class='bg-success rounded-pill me-1 py-1 px-3'>${data[i].response_method}</span> 
                            <span class='bg-success rounded-pill me-1 py-1 px-3'>${data[i].response_status}</span> 
                            <span class='rounded-pill me-1 py-1 px-3 ${data[i].response_time >= 3000 ? 'bg-danger' : data[i].response_time >= 1000 ? 'bg-warning' : 'bg-success' }'>${data[i].response_time.toFixed(2)} ms</span> 
                            on <b>${data[i].endpoint_name}</b> from ${data[i].response_env} environmnet
                            <div class='mt-2'>
                                <button class='btn btn-primary px-2 py-1' style='font-style: underline;'><i class="fa-solid fa-arrow-right"></i> Response Body</button>
                            </div>
                        </div><hr>`
                    )
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }
</script>