<h1 class="fw-bold text-center mb-3" style="font-size:var(--textJumbo) !important;">My Variable</h1>
<table class="table position-relative text-white table-bordered border-white">
    <thead>
        <tr class="text-center">
            <th scope="col">Variable Name</th>
            <th scope="col">Value</th>
            <th scope="col">Created At</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="tb_variable"></tbody>
</table>

<script>
    get_my_variable()
    function get_my_variable() {
        res_time_total = 0
        $('#tb_variable').empty()
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/dictionary/variable`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");
                    
                }
            })
            .done(function (response) {
                let data =  response.data.data

                for(var i = 0; i < data.length; i++){

                    $('#tb_variable').append(`
                        <tr>
                            <td>${data[i].dictionary_name}</td>
                            <td>${data[i].dictionary_value}</td>
                            <td>${get_date_to_context(data[i].created_at,'calendar')}</td>
                            <td><a class="btn btn-primary"><i class="fa-solid fa-gear"></i> Manage</a></td>
                        </tr>
                    `)
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
    }
</script>