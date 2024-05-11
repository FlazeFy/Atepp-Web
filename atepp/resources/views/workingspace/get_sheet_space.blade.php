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
                min-width: 160px;
                position: relative;
                font-size: var(--textXMD);
            }
            .cell button {
                margin: 0;
                width: 100%;
                height: 100%;
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
                    <h5 class="modal-title" id="exampleModalLabel">Comment at cell <span id="cell_number"></span></h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="post_project()"><i class="fa-solid fa-floppy-disk"></i> Save</button>
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
                                <td colspan="5"><button class="btn btn-primary w-100 text-start">
                                    <h6 class="fw-bold">Description</h6>
                                    <p>${data[i].project_desc ?? '-'} ms</p>
                                </td>
                                <td colspan="3"><button class="btn btn-primary w-100"><i class="fa-solid fa-user"></i> Manage</button></td>
                                <td colspan="3"><button class="btn btn-primary w-100"><i class="fa-solid fa-chart-simple"></i> Dashboard</button></td>
                            </tr>
                        `)
                    }
                    $('#tb_working_space').append(`
                        <tr>
                            <th scope="row" class="cell"><button class="btn btn-primary w-100"><i class="fa-solid fa-play"></i></button></th>
                            <td class="cell">${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection">${data[i].endpoint_name}</button>` : data[i].endpoint_name}</td>
                            <td class="cell">${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection">${data[i].folder_name}</button>` : data[i].folder_name ?? '-'}</td>
                            <td class="cell">${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection">${data[i].endpoint_url}</button>` : `<a href="${data[i].endpoint_url}">${data[i].endpoint_url}</a>`}</td>
                            <td class="cell">-</td>
                            <td class="cell">-</td>
                            <td class="cell">-</td>
                            <td class="cell">-</td>
                            <td class="cell">
                                ${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection">
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
                                ${is_edit ? `<button data-bs-toggle="modal" data-bs-target="#cellCommentSection">
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

    function callComment(){
        alert('test')
    }
</script>