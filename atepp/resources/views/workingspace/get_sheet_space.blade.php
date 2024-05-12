<style>
    #working_space_tb_holder {
        overflow-x: auto;
        white-space: nowrap;
    }

    #working_space_tb_holder::-webkit-scrollbar {
        width: 10px;
    }

    #working_space_tb_holder::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #working_space_tb_holder::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 5px;
    }

    #working_space_tb_holder::-webkit-scrollbar-thumb:hover {
        background: #555;
    }   

    <?php
        if(session()->get('comment_mode_key') == "true"){
            echo"
            .cell {
                cursor: pointer;
                padding: 0;
                min-width: 180px;
                position: relative;
                font-size: var(--textXMD);
            }
            .cell button {
                margin: 0;
                width: 100%;
                height: 100%;
                padding-inline: var(--spaceXSM);
                position: absolute;
                top: 0;
                left: 0;
                text-align:start;
            }
            .cell:hover {
                transform: scale(1.1);
                padding: var(--spaceMD);
                background: var(--darkColor);
                border-radius: var(--roundedLG);
            }
            ";
        }
    ?>
</style>

@if(session()->get('comment_mode_key') == true)
    <div class="modal fade" id="cellCommentSection" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Comment at Cell <span id="ctx_comment_title"></span></h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></button>
                </div>
                <div class="modal-body" id="comment_holder">
                </div>
                <div class="modal-footer">
                    <form class="d-inline" id="form-comment">
                        <div class="d-flex justify-content-center w-100">
                            <input id="comment_context" name="comment_context" hidden>
                            <input id="comment_body" name="comment_body" type="text" class="form-control me-2">
                            <input id="endpoint_id" name="endpoint_id" hidden>
                            <button type="button" class="btn btn-success" onclick="post_comment()"><i class="fa-solid fa-floppy-disk"></i> Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<div id="working_space_tb_holder">
    <table class="table position-relative text-white table-bordered border-white">
        <thead>
            <tr class="text-center">
                <th scope="col" class="p-0" rowspan="2" style="width:150px;">
                    <button class="btn btn-primary mb-2 mx-0"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn btn-primary mb-2 mx-0"><i class="fa-solid fa-print"></i></button>
                    <form class="d-inline" method="POST" action="/workingspace/mode/comment_mode/<?php if(session()->get('comment_mode_key') == 'false'){ echo "true"; } else { echo "false"; } ?>">
                        @csrf
                        <button class="btn btn-primary <?php if(session()->get('comment_mode_key') == 'true'){ echo " active "; } ?> mx-0"><i class="fa-solid fa-comment"></i></button>
                    </form>
                    <button class="btn btn-primary mx-0"><i class="fa-solid fa-magnifying-glass"></i></button>
                </th>
                <th scope="col" colspan="3">Endpoint</th>
                <th scope="col" colspan="5">Detail</th>
                <th scope="col" colspan="3">PIC</th>
                <th scope="col" rowspan="2">Reference</th>
                <th scope="col" rowspan="2">Info</th>
                <th scope="col" rowspan="2">Action</th>
            </tr>
            <tr class="text-center">
                <th style="width:260px;">Name</th>
                <th style="width:180px;">Folder</th>
                <th style="width:280px;">URL</th>

                <th style="width:360px;">Parameters</th>
                <th style="width:360px;">Response</th>
                <th style="width:360px;">Request</th>
                <th style="width:360px;">Error</th>
                <th style="width:360px;">Performance</th>

                <th style="width:320px;">Mock By</th>
                <th style="width:320px;">Created By</th>
                <th style="width:320px;">Tested By</th>
            </tr>
        </thead>
        <tbody id="tb_working_space"></tbody>
    </table>
</div>

<script>
    let page = 1
    get_working_space(page)
    function get_working_space(page) {
        const is_edit = <?= session()->get('comment_mode_key')."\n" ?>
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/project/working_space?page=${page}`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");
                    
                }
            })
            .done(function (response) {
                let data =  response.data.data

                let project_before = ''

                for(var i = 0; i < data.length; i++){
                    if(project_before == '' || project_before != data[i].project_slug){
                        project_before = data[i].project_slug
                        $('#tb_working_space').append(`
                            <tr>
                                <th scope="row"><button class="btn btn-primary w-100"><i class="fa-solid fa-box-open"></i></button></th>
                                <td colspan="3"><button class="btn btn-primary py-3 w-100 h-100 text-start"><span class="rounded-pill px-3 py-1 bg-success me-2">${data[i].project_category}</span> ${data[i].project_title}</button></td>
                                <td colspan="5">
                                    <div id="section-show-desc" class="d-block">
                                        <button class="btn btn-primary w-100 text-start" onclick="toogle_edit_desc()" title="Click to edit">
                                            <h6 class="fw-bold">Description</h6>
                                            <p>${data[i].project_desc ?? '-'}</p>
                                        </button>
                                    </div>
                                    <div id="section-edit-desc" class="d-none">
                                        <form id="form-edit-project-desc">
                                            <textarea class="form-control" id="project_desc" value="${data[i].project_desc ?? ''}">${data[i].project_desc ?? ''}</textarea>
                                            <div class="d-flex justify-content-end mt-2">
                                                <a id="project_desc_msg" class="input-length"></a>
                                                <a class="btn btn-danger me-2" onclick="toogle_edit_desc()"><i class="fa-regular fa-circle-xmark"></i></a>
                                                <a class="btn btn-success" onclick="put_project_desc('${data[i].project_slug}')"><i class="fa-solid fa-floppy-disk"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td colspan="3"><button class="btn btn-primary w-100"><i class="fa-solid fa-user"></i> Manage</button></td>
                                <td colspan="3"><button class="btn btn-primary w-100"><i class="fa-solid fa-chart-simple"></i> Dashboard</button></td>
                            </tr>
                        `)
                    }
                    $('#tb_working_space').append(`
                        <tr>
                            <th scope="row"><button class="btn btn-primary w-100"><i class="fa-solid fa-play"></i></button></th>
                            <td class="cell">${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection" onclick="callComment('Name','${data[i].endpoint_id}')">${data[i].endpoint_name}</button>` : data[i].endpoint_name}</td>
                            <td class="cell">${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection" onclick="callComment('Folder','${data[i].endpoint_id}')">${data[i].folder_name}</button>` : data[i].folder_name ?? '-'}</td>
                            <td class="cell">${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection" onclick="callComment('URL','${data[i].endpoint_id}')">${data[i].endpoint_url}</button>` : `<a href="${data[i].endpoint_url}">${data[i].endpoint_url}</a>`}</td>
                            <td class="cell">-</td>
                            <td class="cell">-</td>
                            <td class="cell">-</td>
                            <td class="cell">-</td>
                            <td class="cell">
                                ${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection" onclick="callComment('Performance','${data[i].endpoint_id}')">
                                    <h6 class="fw-bold">Max Response Time</h6>
                                    <p>${data[i].max_response_time ?? '-'} ms</p>
                                    <h6 class="fw-bold">Min Response Time</h6>
                                    <p>${data[i].min_response_time ?? '-'} ms</p>
                                    <h6 class="fw-bold">Average</h6>
                                    <p>${data[i].avg_response_time ?? '-'} ms</p>
                                    </button>` :
                                    `<h6 class="fw-bold">Max Response Time</h6>
                                    <p>${data[i].max_response_time ?? '-'} ms</p>
                                    <h6 class="fw-bold">Min Response Time</h6>
                                    <p>${data[i].min_response_time ?? '-'} ms</p>
                                    <h6 class="fw-bold">Average</h6>
                                    <p>${data[i].avg_response_time ?? '-'} ms</p>`
                                }
                            </td>
                            <td class="cell">-</td>
                            <td class="cell">
                                ${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection" onclick="callComment('Created By','${data[i].endpoint_id}')">
                                    <p>${data[i].created_by}</p>
                                    <p style="font-size:var(--textMD);">At ${get_date_to_context(data[i].created_at,'calendar')}</p>
                                    </button>` :
                                    `
                                    <p>${data[i].created_by}</p>
                                    <p style="font-size:var(--textMD);">At ${get_date_to_context(data[i].created_at,'calendar')}</p>
                                    `
                                }
                            </td>
                            <td class="cell">-</td>
                            <td class="cell">-</td>
                            <td><button class="btn btn-primary w-100"><i class="fa-solid fa-circle-info"></i></button></td>
                            <td><button class="btn btn-primary w-100"><i class="fa-solid fa-gear"></i></button></td>
                        </tr>
                    `)
                }

                $('#tb_working_space').append(`
                    <tr>
                        <th scope="row"><button class="btn btn-primary w-100"><i class="fa-solid fa-plus"></i></button></th>
                        <td colspan="3"><button class="btn btn-primary w-100">See More <span>(0)</span> Endpoint</button></td>
                        <td colspan="5"><button class="btn btn-primary w-100"><i class="fa-solid fa-book"></i> Dictionary</button></td>
                        <td colspan="3"><button class="btn btn-primary w-100"><i class="fa-solid fa-users"></i> Social</button></td>
                        <td colspan="3"><button class="btn btn-primary w-100"><i class="fa-solid fa-trash"></i> Trash</button></td>
                    </tr>
                `)
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
    }

    function get_comment_by_endpoint_ctx(endpoint_id, ctx) {
        const is_edit = <?= session()->get('comment_mode_key')."\n" ?>
        $('#comment_holder').empty()
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/comment/by/${endpoint_id}/${ctx}`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json")
                    xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>")
                }
            })
            .done(function (response) {
                let data =  response.data.data

                let project_before = ''

                for(var i = 0; i < data.length; i++){
                    $('#comment_holder').append(`
                        <div class="mb-3 text-white">
                            <h6>${data[i].comment_body}</h6>
                            <a class="fst-italic" style="font-size:var(--textXMD);">@username at ${get_date_to_context(data[i].created_at,'calendar')}</a>
                        </div>
                    `)
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
    }

    function callComment(ctx, id){
        $('#ctx_comment_title').text(ctx)
        $('#comment_context').val(ctx)
        $('#endpoint_id').val(id)
        get_comment_by_endpoint_ctx(id, ctx)
    }

    function post_comment(){
        $.ajax({
            url: '/api/v1/comment', 
            type: 'POST',
            data: $('#form-comment').serialize(),
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                $('#comment_body').val('')
                const ctx = $('#comment_context').val()
                const id = $('#endpoint_id').val()
                get_comment_by_endpoint_ctx(id, ctx)
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                if(allMsg){
                    $('#all_msg').html(icon + allMsg)
                }
            }
        });
    }

    function toogle_edit_desc(){
        if($('#section-edit-desc').attr("class") == 'd-none'){
            form_count_char_limit('project_desc', 'project_desc_msg', 1000)
            $('#section-edit-desc').removeClass().addClass("d-block")
            $('#section-show-desc').removeClass().addClass("d-none")
        } else {
            $('#section-edit-desc').removeClass().addClass("d-none")
            $('#section-show-desc').removeClass().addClass("d-block")
        }
    }
    function put_project_desc(slug){
        $.ajax({
            url: `/api/v1/project/put_project_desc/${slug}`,
            type: 'PUT',
            data: $('#form-edit-project-desc').serialize(),
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                
            }
        });
    }
</script>