<div class="position-relative">
    <h1 class="fw-bold text-center mb-3" style="font-size:var(--textJumbo) !important;">My Project</h1>
    <div class="row ps-3">
        <div class="col">
            <button class="btn btn-success w-100 py-4" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                <h1 class="fw-bold" style="font-size:calc(var(--textXJumbo)*2) !important;"><i class="fa-solid fa-plus"></i></h1> 
                <h2 class="mb-3">Add Project</h2>
                <span class="bg-warning rounded-pill px-3 py-1 fw-bold" style="font-size:var(--textXMD) !important;"><i class="fa-solid fa-fire"></i> Unlimited</span>
            </button>
        </div>
        <div class="col">
            <button class="btn btn-primary w-100 py-4">
                <h1 class="fw-bold" style="font-size:calc(var(--textXJumbo)*2) !important;"><i class="fa-solid fa-file-export"></i></h1> 
                <h2 class="mb-3">Import & Export</h2>
                <span class="bg-primary rounded-pill px-3 py-1 fw-bold" style="font-size:var(--textXMD) !important;">JSON, CSV, XLS</span>
            </button>
        </div>
        <div class="col">
            <button class="btn btn-primary w-100 py-4">
                <h1 class="fw-bold" style="font-size:calc(var(--textXJumbo)*1.2) !important;" id="total_project">0</h1> 
                <h2 class="mb-3">My Project</h2>
                <div class="bg-primary rounded-pill px-3 py-1 fw-bold" style="font-size:var(--textMD) !important;">
                    <p class="mb-0">Last Activity</p>
                    <p class="mb-0" id="last_activity">20/04/12</p>
                </div>
            </button>
        </div>
    </div>
    <div id="project_holder" class="ps-3 mt-4"></div>
</div>

<script>
    get_stats_perf()
    function get_stats_perf() {
        $.ajax({
                url: "http://127.0.0.1:8000/api/v1/project/detail",
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");
                    
                }
            })
            .done(function (response) {
                let data =  response.data
                document.getElementById(`total_project`).innerHTML = data.length
                let dates = []
                let element

                for(var i = 0; i < data.length; i++){
                    dates.push(data[i].created_at)
                    $('#project_holder').append(
                        ` <button class="btn btn-primary w-100 text-start mb-3 p-3" href="" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <h1 style="font-size:var(--textXJumbo); font-weight:bold;" class="mb-1">${data[i].project_title}</h1>
                            <div class="d-flex justify-content-start">
                                <span style="font-size:var(--textLG); font-weight:600;" class="bg-success px-3 py-1 me-1 rounded-pill">${data[i].project_category}</span><br>
                                <span style="font-size:var(--textLG); font-weight:600;" class="bg-primary px-3 py-1 rounded-pill">${data[i].total_endpoint} Endpoint</span><br>
                            </div>
                            <div class="mt-3">${data[i].project_desc ?? '<span class="fst-italic">- No Description Provided -</span>'}</div>
                            <div class="mt-3" style="font-size:var(--textXMD)">Created at : ${get_date_to_context(data[i].created_at,'calendar')}</div>
                        </button>
                        `
                    )
                }

                const last_activity = generate_last_date(dates)
                document.getElementById('last_activity').innerHTML = last_activity
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }
</script>