<div class="ms-3">
    <form action="/project/select_project" method="POST">
        @csrf
        <select class="form-select select-group w-100 py-3" onchange="this.form.submit()" id="project" name="project_slug" aria-label="Default select example"></select>
    </form>
    <div class="d-flex justify-content-between">
        <h4 class="fw-bold mt-3">Folder</h4>
        <button class="btn btn-primary" onclick="add_new_folder()"><i class="fa-solid fa-folder-plus"></i></button>
    </div>
    <div class="mt-2" id="folder_holder"></div>
</div>

<script>
    get_list_project()
    const open_project = '<?php if(session()->get('project_key')){ echo session()->get('project_key'); } else { echo 'null'; } ?>'

    function get_list_project() {
        $('#project').append(`<option>-</option>`)
        $.ajax({
                url: "http://127.0.0.1:8000/api/v1/project",
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                let data =  response.data;

                for(var i = 0; i < data.length; i++){
                    $('#project').append(`<option value='${data[i].project_slug}' ${data[i].project_slug == open_project ? 'selected' : ''}>${data[i].project_title}</option>`)
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }

    if(open_project != null){
        get_list_folder(open_project)
    }
    function get_list_folder(slug) {
        $('#project').append(`<option>-</option>`)
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/project/folder/${slug}`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                let data =  response.data;

                for(var i = 0; i < data.length; i++){
                    $('#folder_holder').append(
                        ` <a class="btn btn-primary w-100 text-start mb-2" data-bs-toggle="collapse" href="#collapse_${data[i].folder_slug}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>${data[i].folder_name}</span><i class="fa-solid fa-square-caret-down"></i>
                            </div>
                        </a>
                        <div class="collapse multi-collapse bg-transparent ${i == 0 ? 'show' : ''}" id="collapse_${data[i].folder_slug}">
                            <div class="pt-2" id="${data[i].folder_slug}_endpoint_holder"></div>
                        </div>
                        `
                    )
                    get_endpoint_by_folder(data[i].folder_slug)
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }

    function get_endpoint_by_folder(slug) {
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/project/endpoint/folder/${slug}`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                let data =  response.data;

                for(var i = 0; i < data.length; i++){
                    $(`#${slug}_endpoint_holder`).append(`
                        <button class='btn-endpoint' onclick='open_endpoint_via_folder("${data[i].id}","${data[i].endpoint_url}", method)'>
                            <span class='bg-success px-2 me-1 py-1 rounded-pill' onclick='' style='font-size: var(--textSM);'>${data[i].endpoint_method}
                            </span>${data[i].endpoint_name}
                        </button>`
                    )
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }

    function add_new_folder(slug){
        $('#folder_holder').append(`<input class="form-control btn btn-primary text-start mb-3" onblur="post_folder(this.value,open_project)">`)
    }

    function post_folder(val,slug){
        $.ajax({
            url: `http://127.0.0.1:8000/api/v1/project/folder/${slug}`,
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({ 
                slug: slug,
                folder_name: val,
                folder_desc: null,
                folder_pin_code: null
            }), 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response, textStatus, jqXHR) {
                get_list_endpoint()
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                // Do someting
            }
        })
    }

    function open_endpoint_via_folder(id, url, method){
        document.getElementById('endpoint_holder').value = url
        document.getElementById('method').value = method
        document.getElementById('endpoint_id').value = id

        get_list_history(id)
    }
</script>