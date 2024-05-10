<div class="modal fade" id="toptenResponseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Top 10 <span id="ctx_top_ten_title"></span></h5>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></button>
            </div>
            <div class="modal-body" id="dt_top_ten">
            </div>
        </div>
    </div>
</div>

<script>
    function get_endpoint_top_ten(ctx){
        $('#ctx_top_ten_title').text(`Most ${ctx}est endpoint's response`)
        $('#dt_top_ten').empty()
        $.ajax({
            url: `/api/v1/project/endpoint/top/${ctx}`,
            type: 'GET',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                const data = response.data

                for (let i = 0; i < data.length; i++) {
                    $('#dt_top_ten').append(`
                        <div class="container w-100 p-3 mb-2">
                            <div class="d-flex justify-content-between mb-2">
                                <h6><span class="text-success fw-bold" style="font-size:var(--textJumbo);">#${i+1}</span> ${data[i].endpoint_name}</h6>
                                <span class="bg-${ctx == 'fast' ? 'success':'danger'} rounded-pill py-2 px-3 fw-bold" style="font-size:var(--textXMD);"><h6>${data[i].response_time} ms</h6></span>
                            </div>
                            <a>${data[i].endpoint_url}</a> 
                            <p style="font-size:var(--textMD);" class="fst-italic">Run at ${get_date_to_context(data[i].created_at,'calendar')}</p>
                        </div>
                    `)  
                }
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                
            }
        });
    }
</script>