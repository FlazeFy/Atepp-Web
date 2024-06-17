<h1 class="fw-bold text-center mb-3" style="font-size:var(--textJumbo) !important;">Warehouse</h1>
<table class="table position-relative text-white table-bordered border-white">
    <thead class="text-center">
        <tr>
            <th>Filename</th>
            <th>Context</th>
            <th>Type</th>
            <th>Generated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="tb_warehouse"></tbody>
</table>

<script>
    get_my_warehouse()
    function get_my_warehouse() {
        res_time_total = 0
        $('#tb_warehouse').empty()
        $.ajax({
                url: `http://127.0.0.1:8000/api/v1/docs/warehouse`,
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer <?= session()->get("token_key"); ?>");
                }
            })
            .done(function (response) {
                let data =  response.data

                data.forEach(el => {
                    const path = el.name.split("/")
                    const name = path[3]
                    const ctx = `<span class="btn btn-primary rounded-pill">${ucFirst(path[0])}</span> <span class="bg-primary px-3 py-2 rounded-pill">${ucFirst(path[1])}</span>`
                    let type = el.content_type

                    if(type == 'application/pdf'){
                        type = 'Pdf'
                    }

                    $("#tb_warehouse").append(`
                        <tr>
                            <td>${name}</td>
                            <td class="text-center">${ctx}</td>
                            <td class="pt-3 text-center"><span class="bg-primary px-3 py-2 rounded-pill">${type}</span></td>
                            <td class="text-center">${get_date_to_context(el.created_at, 'datetime')}</td>
                            <td class="text-center"><a class="btn btn-primary w-100" href="${el.download_url}"><i class="fa-solid fa-eye"></i> Preview</a></td>
                        </tr>
                    `)
                });
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to get warehouse!",
                });
            });
    }
</script>