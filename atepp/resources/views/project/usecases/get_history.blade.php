<div id="history_holder" class="pt-2"></div>

<script>
    function get_list_history(id) {
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/project/response/${id}`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                let data =  response.data;

                for(var i = 0; i < data.length; i++){
                    $('#history_holder').append(`<p class='pt-3 pb-2'><span class='bg-success rounded-pill me-1 py-1 px-3'>${data[i].response_method}</span> on ${data[i].endpoint_name} 
                        with status : ${data[i].response_status} and time taken : ${data[i].response_time} ms from 
                        ${data[i].response_env} environmnet <a class='btn-link' style='font-style: underline;'><i class="fa-solid fa-arrow-right"></i> Response Body</a></p><hr>`
                    )
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }
</script>