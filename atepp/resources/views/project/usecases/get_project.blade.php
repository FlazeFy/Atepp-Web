<div class="ms-3">
    <form action="/project/select_project" method="POST">
        @csrf
        <select class="form-select select-group w-100 py-3" onchange="this.form.submit()" id="project" name="project_slug" aria-label="Default select example"></select>
    </form>
    <h4 class="fw-bold mt-3">Folder</h4>

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
                        ` <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapse_${data[i].folder_slug}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>${data[i].folder_name}</span><i class="fa-solid fa-square-caret-down"></i>
                            </div>
                        </a>
                        <div class="collapse multi-collapse bg-transparent" id="collapse_${data[i].folder_slug}">
                            <div class="pt-2">
                                Some placeholder content for the first collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.
                            </div>
                        </div>
                        
                        `
                    )
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }
</script>