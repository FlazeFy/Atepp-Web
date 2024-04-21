<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form id="form-project">
                    <label>Title</label>
                    <input id="project_title" name="project_title" type="text" class="form-control mb-2">

                    <label>Category</label>
                    <select class="form-select mb-2" aria-label="Default select example" id="project_category" name="project_category">
                        <option selected>-</option>
                        <option value="Health">Health</option>
                        <option value="Education">Education</option>
                        <option value="Company">Company</option>
                        <option value="E-Commerce">E-Commerce</option>
                        <option value="Blog">Blog</option>
                        <option value="Statistic">Statistic</option>
                        <option value="Tech">Tech</option>
                    </select>

                    <label>Type</label>
                    <select class="form-select mb-2" aria-label="Default select example" id="project_type" name="project_type">
                        <option selected>-</option>
                        <option value="private">Private</option>
                        <option value="personal">Personal</option>
                        <option value="public">Public</option>
                    </select>

                    <label>Description</label>
                    <textarea id="project_desc" name="project_desc" type="text" class="form-control mb-2" rows="5"></textarea>

                    <label>Main Language</label>
                    <select class="form-select mb-2" aria-label="Default select example" id="project_main_lang" name="project_main_lang" >
                        <option selected>-</option>
                        <option value="no-lang">Not Deciced</option>
                        <option value="javascript">Javascript</option>
                        <option value="golang">Golang</option>
                        <option value="java">Java</option>
                        <option value="php">PHP</option>
                        <option value="c#">C#</option>
                        <option value="c++">C++</option>
                        <option value="ruby">Ruby</option>
                        <option value="python">Python</option>
                        <option value="dart">Dart</option>
                    </select>

                    <label>Pin Code</label>
                    <input id="project_pin_code" name="project_pin_code" type="number" class="form-control mb-2">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="post_project()"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    function post_project(){
        $.ajax({
            url: '/api/v1/project',
            type: 'POST',
            data: $('#form-project').serialize(),
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                get_stats_perf()
                $('#addProjectModal').modal('hide')
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
                        // if(response.responseJSON.result.hasOwnProperty('username')){
                        //     usernameMsg = response.responseJSON.result.username[0]
                        // }
                    }
                    
                } else if(response && response.responseJSON && response.responseJSON.hasOwnProperty('errors')){
                    allMsg = response.responseJSON.errors.result[0]
                } else {
                    allMsg = errorMessage
                }

                //Set to html
                if(allMsg){
                    $('#all_msg').html(icon + allMsg)
                }
            }
        });
    }
</script>