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
                            <td>
                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manage_var_${i}_modal"><i class="fa-solid fa-gear"></i> Manage</a>
                                <div class="modal fade" id="manage_var_${i}_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Manage Variable</h5>
                                                <a type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></a>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form-edit-var-${i}">
                                                    <input hidden name="id" value="${data[i].id}" id="id_${i}">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label text-white">Name</label>
                                                        <input type="text" name="dictionary_name" id="dictionary_name_${i}" value="${data[i].dictionary_name}" class="form-control" aria-describedby="emailHelp">
                                                        <a class="error_input" id="key_${i}_msg"></a>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label text-white">Value</label>
                                                        <input type="text" name="dictionary_value" id="dictionary_value_${i}" value="${data[i].dictionary_value}" class="form-control" aria-describedby="emailHelp">
                                                        <a class="error_input" id="val_${i}_msg"></a>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="exampleInputEmail1" class="form-label text-white mb-0">Created At</label><br>
                                                                <label for="exampleInputEmail1" class="form-label text-white fst-italic" style="font-size: var(--textXMD);" id="created_at_${i}">${get_date_to_context(data[i].created_at, 'calendar')}</label>
                                                            </div>
                                                            <div class="col text-end">
                                                                <label for="exampleInputEmail1" class="form-label text-white mb-0">Last Update</label><br>
                                                                <label for="exampleInputEmail1" class="form-label text-white fst-italic" style="font-size: var(--textXMD);" id="updated_at_${i}">${get_date_to_context(data[i].updated_at, 'calendar')}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="fst-italic text-danger" style="font-size: var(--textMD);" id="all_msg_var_${i}"></a>
                                                    <div class="row">
                                                        <div class="col">
                                                            <a class="btn btn-danger w-100 py-2" onclick="delete_variable(${i})"><i class="fa-solid fa-trash"></i> Delete</a>
                                                        </div>
                                                        <div class="col text-end">
                                                            <a class="btn btn-primary w-100 py-2" onclick="edit_variable(${i})"><i class="fa-solid fa-floppy-disk"></i> Save Changes</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
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
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to get variable!",
                });
            });
    }

    function addVariableForm(id){
        $('#tb_variable').append(`
            <tr>
                <td>
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
                </td>
                <td><a class="btn btn-danger" onclick="get_my_variable()">Cancel</a></td>
                <td><a class="btn btn-success" onclick="submit_var()">Save</a></td>
            </tr>
        `)
    }

    function submit_var(){
        $.ajax({
            url: `http://127.0.0.1:8000/api/v1/dictionary/variable`,
            type: 'POST',
            data: {
                dictionary_name: $('#dictionary_name').val(),
                dictionary_value: $('#dictionary_value').val()
            },
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                get_my_variable()
                Swal.fire({
                    title: "Success!",
                    text: "New variable is added",
                    icon: "success"
                });
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to add variable!",
                });

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

    function edit_variable(idx){
        const id = $(`#id_${idx}`).val()
        $(`#all_msg_var_${idx}`).empty()
        $.ajax({
            url: `http://127.0.0.1:8000/api/v1/dictionary/variable/${id}`,
            type: 'PUT',
            data: $(`#form-edit-var-${idx}`).serialize(),
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                $(`#manage_var_${idx}_modal`).modal('hide')
                get_my_variable()
                Swal.fire({
                    title: "Success!",
                    text: "Variable is updated",
                    icon: "success"
                });
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to update variable!",
                });

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
                    $(`#all_msg_var_${i}`).html(icon + allMsg)
                }
            }
        });
    }

    function delete_variable(idx){
        const id = $(`#id_${idx}`).val()
        $.ajax({
            url: `http://127.0.0.1:8000/api/v1/dictionary/variable/${id}`,
            type: 'DELETE',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                $(`#manage_var_${idx}_modal`).modal('hide')
                get_my_variable()
                Swal.fire({
                    title: "Success!",
                    text: "Variable is deleted",
                    icon: "success"
                });
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to delete variable!",
                });

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
                    $(`#all_msg_var_${i}`).html(icon + allMsg)
                }
            }
        });
    }
</script>