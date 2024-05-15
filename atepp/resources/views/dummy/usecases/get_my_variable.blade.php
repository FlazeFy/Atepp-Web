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

                $('#tb_variable').append(`
                    <tr>
                        <td colspan="4" class="text-center">
                            <a class="btn w-100" onclick="addVariableForm()"><i class="fa-solid fa-plus"></i> Add Variable</a>
                        </td>
                    </tr>
                `)
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
    }

    function addVariableForm(id){
        $('#tb_variable').append(`
            <tr>
                <td>
                    <form id="form-add-var" class="d-block">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="dictionary_name" name="dictionary_name" required>
                        <label for="floatingInput">Variable Name</label>
                    </div>
                </td>
                <td>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="dictionary_value" name="dictionary_value">
                        <label for="floatingInput">Value</label>
                    </div>
                    </form>
                </td>
                <td><a class="btn btn-danger">Cancel</a></td>
                <td><a class="btn btn-success" onclick="submit_var()">Save</a></td>
            </tr>
        `)
    }

    function submit_var(){
        $.ajax({
            url: `http://127.0.0.1:8000/api/v1/dictionary/variable`,
            type: 'POST',
            data: $('#form-add-var').serialize(),
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                location.reload()
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                var errorMessage = "Unknown error occurred"
                var allMsg = null
                var icon = `<i class='fa-solid fa-triangle-exclamation'></i> `

                if (response && response.responseJSON && response.responseJSON.hasOwnProperty('result')) {   
                    //Error validation
                    if(typeof response.responseJSON.result === "string"){
                        allMsg = response.responseJSON.result
                    } else {

                    }
                    
                } else if(response && response.responseJSON && response.responseJSON.hasOwnProperty('errors')){
                    allMsg = response.responseJSON.errors.result[0]
                } else {
                    allMsg = errorMessage
                }
                if(allMsg){
                    $('#all_msg').html(icon + allMsg)
                }
            }
        });
    }
</script>