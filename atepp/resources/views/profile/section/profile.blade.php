<div class="row">
    <div class="col-lg-7">
        <div class="alert alert-warning">
            <h6 class="mb-2"><i class="fa-solid fa-circle-info"></i> Info</h6>
            <a>You can only update username, email address, company, and job for 3 times a day</a>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label text-white">Username</label>
            <input type="text" name="username" id="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <a class="error_input" id="username_msg"></a>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label text-white">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <a class="error_input" id="email_msg"></a>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label text-white">Company</label>
            <input type="text" name="company" id="company" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <a class="error_input" id="company_msg"></a>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label text-white">Social Media</label>
            <div class="border rounded py-2" style="min-height: 40px;" id="social_media_holder"></div>
            <a class="error_input" id="social_media_msg"></a>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label text-white">Job</label>
            <input type="text" name="job" id="job" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <a class="error_input" id="job_msg"></a>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col">
                    <label for="exampleInputEmail1" class="form-label text-white mb-0">Joined Since</label><br>
                    <label for="exampleInputEmail1" class="form-label text-white fst-italic" style="font-size: var(--textXMD);" id="created_at"></label>
                </div>
                <div class="col text-end">
                    <label for="exampleInputEmail1" class="form-label text-white mb-0">Last Update</label><br>
                    <label for="exampleInputEmail1" class="form-label text-white fst-italic" style="font-size: var(--textXMD);" id="updated_at"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">

    </div>
</div>

<script>
    get_my_profile()
    function get_my_profile() {
        res_time_total = 0
        $('#tb_variable').empty()
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/user`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");
                    
                }
            })
            .done(function (response) {
                let data =  response.data
                const socmeds = data.social_media

                $('#username').val(data.username)
                $('#email').val(data.email)
                $('#company').val(data.company)
                $('#job').val(data.job)
                $('#created_at').text(get_date_to_context(data.created_at, 'calendar'))
                $('#updated_at').text(get_date_to_context(data.updated_at, 'calendar'))

                if(socmeds){
                    socmeds.forEach((el,idx) => {
                        $('#social_media_holder').append(`
                            <a class='btn btn-socmed' data-bs-toggle="modal" data-bs-target="#socmed_${idx}_edit_modal"><i class="fa-brands fa-${el.socmed_name}"></i> ${ucFirst(el.socmed_name)}</a>
                            <div class="modal fade" id="socmed_${idx}_edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Social Media</h5>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="exampleInputEmail1" class="form-label text-white">Platform</label>
                                            <select class="form-select mb-3" aria-label="Default select example">
                                                <option value="instagram" ${el.socmed_name == "instagram" ? "selected":""}>Instagram</option>
                                                <option value="github" ${el.socmed_name == "github" ? "selected":""}>Github</option>
                                            </select>
                                            <label for="basic-url" class="form-label">Account URL</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon3">${
                                                    el.socmed_name == "github" ? "https://github.com/" :
                                                    el.socmed_name == "instagram" ? "https://www.instagram.com/" : ""
                                                }</span>
                                                <input type="text" class="form-control" id="basic-url" value="${
                                                    el.socmed_name == "github" ? el.socmed_url.replace("https://github.com/","") :
                                                    el.socmed_name == "instagram" ? el.socmed_url.replace("https://www.instagram.com/","") : ""
                                                }" aria-describedby="basic-addon3">
                                            </div>
                                            <button class="btn btn-danger w-100 mt-3"><i class="fa-solid fa-trash"></i> Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `)
                    });
                }
                $('#social_media_holder').append(`
                    <a class='btn btn-socmed bg-success' data-bs-toggle="modal" data-bs-target="#add_socmed_modal" title="Add Social Media"><i class="fa-solid fa-plus"></i></a>
                    <div class="modal fade" id="add_socmed_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Social Media</h5>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></button>
                                </div>
                                <div class="modal-body">
                                    <label for="exampleInputEmail1" class="form-label text-white">Platform</label>
                                    <select class="form-select mb-3" aria-label="Default select example">
                                        <option selected>- Select Social Media-</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="github">Github</option>
                                    </select>
                                    <label for="basic-url" class="form-label">Account URL</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon3">-</span>
                                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `)
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
    }
</script>