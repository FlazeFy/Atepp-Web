<h1 class="fw-bold text-center mb-3" style="font-size:var(--textJumbo) !important;">My Service</h1>
<table class="table position-relative text-white table-bordered border-white">
    <thead class="text-center">
        <tr>
            <th scope="col">Service Platforn</th>
            <th scope="col">ID</th>
            <th scope="col">Created At</th>
            <th scope="col">Validation Status</th>
        </tr>
    </thead>
    <tbody id="tb_service" class="text-center"></tbody>
</table>

<script>
    get_my_service()
    function get_my_service() {
        res_time_total = 0
        $('#tb_service').empty()
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/user/service`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");
                }
            })
            .done(function (response) {
                let data =  response.data

                for(var i = 0; i < data.length; i++){

                    $('#tb_service').append(`
                        <tr>
                            <td>${ucFirst(data[i].bot_platform)}</td>
                            <td>${data[i].bot_id}</td>
                            <td>${get_date_to_context(data[i].created_at,'calendar')}</td>
                            <td>${data[i].is_valid == 1 ? `<b class="text-success">Validated!</b>` : `<a class="btn btn-primary w-100"><i class="fa-solid fa-paper-plane"></i> Send Validation</a>`}</td>
                        </tr>
                    `)
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
    }
</script>