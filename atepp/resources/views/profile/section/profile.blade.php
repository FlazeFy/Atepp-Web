<div class="row">
    <div class="col-lg-7">
        <div class="alert alert-warning">
            <h6 class="mb-2"><i class="fa-solid fa-circle-info"></i> Info</h6>
            <a>You can only update username, email address, company, and job for 3 times a day</a>
        </div>
        <form id="form-update-user-profile">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label text-white">Username</label>
                <input type="text" name="username" id="username" class="form-control" aria-describedby="emailHelp">
                <a class="error_input" id="username_msg"></a>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label text-white">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp">
                <a class="error_input" id="email_msg"></a>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label text-white">Phone Number</label>
                <input type="phone" name="phone" id="phone" class="form-control" aria-describedby="emailHelp">
                <a class="error_input" id="phone_msg"></a>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label text-white">Company</label>
                <input type="text" name="company" id="company" class="form-control" aria-describedby="emailHelp">
                <a class="error_input" id="company_msg"></a>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label text-white">Social Media</label>
                <div class="border rounded py-2" style="min-height: 40px;" id="social_media_holder"></div>
                <a class="error_input" id="social_media_msg"></a>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label text-white">Job</label>
                <input type="text" name="job" id="job" class="form-control"  aria-describedby="emailHelp">
                <a class="error_input" id="job_msg"></a>
            </div>
            <div id="btn-edit-profile-holder"></div>
        </form>
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
    let username = ''
    let email = ''
    let company = ''
    let job = ''
    let phone = ''

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
                username = data.username
                email = data.email
                company = data.company
                job = data.job
                phone = data.phone

                $('#username').val(username)
                $('#email').val(email)
                $('#company').val(company)
                $('#job').val(job)
                $('#phone').val(phone)

                $('#created_at').text(get_date_to_context(data.created_at, 'calendar'))
                $('#updated_at').text(get_date_to_context(data.updated_at, 'calendar'))

                if(socmeds){
                    $('#social_media_holder').empty()
                    socmeds.forEach((el,idx) => {
                        $('#social_media_holder').append(`
                            <a class='btn btn-socmed' data-bs-toggle="modal" data-bs-target="#socmed_${idx}_edit_modal"><i class="fa-brands fa-${el.socmed_name}"></i> ${ucFirst(el.socmed_name)}</a>
                            <div class="modal fade" id="socmed_${idx}_edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Social Media</h5>
                                            <a type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></a>
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
                                            <a class="btn btn-danger w-100 mt-3"><i class="fa-solid fa-trash"></i> Remove</a>
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
                                    <a type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></a>
                                </div>
                                <div class="modal-body">
                                    <label for="exampleInputEmail1" class="form-label text-white">Platform</label>
                                    <select class="form-select mb-3" aria-label="Default select example" id="social_media_platform">
                                        <option selected>- Select Social Media-</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="github">Github</option>
                                    </select>
                                    <label for="basic-url" class="form-label">Account URL</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="base_url_platform">-</span>
                                        <input type="text" class="form-control" id="socmed_account" aria-describedby="basic-addon3">
                                    </div>
                                    <div id="btn-submit-socmed-holder"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `)
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to get my profile!",
                });
            });
    }

    $(document).ready(function() {
        $(document).on("input", "#username, #email, #company, #job", function() {
            const newVal = $(this).val()
            const id = $(this).attr('id')
            let is_changed_username = false 
            let is_changed_email = false 
            let is_changed_company = false 
            let is_changed_job = false 
            let is_changed_phone = false 

            if (id === 'username' && newVal !== username) {
                is_changed_username = true
            } else if (id === 'email' && newVal !== email) {
                is_changed_email = true
            } else if (id === 'company' && newVal !== company) {
                is_changed_company = true
            } else if (id === 'job' && newVal !== job) {
                is_changed_job = true
            } else if (id === 'phone' && newVal !== phone) {
                is_changed_phone = true
            }
            
            if(is_changed_username || is_changed_email || is_changed_company || is_changed_job || is_changed_phone){
                $("#btn-edit-profile-holder").empty().append(`
                    <a class="btn btn-primary w-100 my-3" onclick="edit_profile()"><i class="fa-solid fa-floppy-disk"></i> Save Changes</a>
                `)
            } else {
                $("#btn-edit-profile-holder").empty()
            }
        })
        $('#social_media_holder').on('change', '#social_media_platform', function() {
            const val = $('#social_media_platform').val()
            if(val == 'github'){
                $('#base_url_platform').text('https://github.com/')
            } else if(val == 'instagram'){
                $('#base_url_platform').text('https://www.instagram.com/')
            } else {
                $('#btn-submit-socmed-holder').empty()
                $('#base_url_platform').text('-')
                $('#socmed_account').val(null)
            }
        });
        $('#social_media_holder').on('input','#socmed_account', function() {
            const val = $(this).val()
            const val_platform = $('#base_url_platform').text()

            if(val.length != 0 && val_platform != '-' && val_platform != null){
                $('#btn-submit-socmed-holder').empty().append(`
                    <a class="btn btn-primary w-100 mt-2" onclick="post_socmed()">Add Social Media</a>
                `)
            } else {
                $('#btn-submit-socmed-holder').empty()
            }
        })
    })

    function edit_profile(){
        $.ajax({
            url: '/api/v1/user/edit_profile', 
            type: 'PUT',
            data: $('#form-update-user-profile').serialize(),
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");    
            },
            success: function(response) {
                get_my_profile()
                Swal.fire({
                    title: "Success!",
                    text: "Your profile is updated",
                    icon: "success"
                });
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                var allMsg = null
                var icon = `<i class='fa-solid fa-triangle-exclamation'></i> `

                if(allMsg){
                    $('#all_msg').html(icon + allMsg)
                }

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to update profile!",
                });
            }
        });
    }

    function post_socmed(){
        $.ajax({
            url: `http://127.0.0.1:8000/api/v1/user/add_socmed`,
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({ 
                socmed_name: $('#social_media_platform').val(),
                socmed_url: `${$('#base_url_platform').text()}${$('#socmed_account').val()}`
            }), 
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json")
                xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>")
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response, textStatus, jqXHR) {
                $(`#add_socmed_modal`).modal('hide')
                Swal.fire({
                    title: "Success!",
                    text: "Your social media is updated",
                    icon: "success"
                });
                get_my_profile()
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to update social media!",
                });
            }
        })
    }
</script>