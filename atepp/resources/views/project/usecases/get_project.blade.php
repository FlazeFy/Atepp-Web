<select class="form-select select-group w-100 ms-3 py-3" id="project" aria-label="Default select example"></select>

<script>
    get_list_project()
    function get_list_project() {
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
                    $('#project').append(`<option value='${data[i].project_slug}'>${data[i].project_title}</option>`)
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }
</script>