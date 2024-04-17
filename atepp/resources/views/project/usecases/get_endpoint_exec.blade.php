<style>
    .form-select.select-group {
        background: var(--darkColor);
        font-weight: 600;
        font-size: var(--textXLG);
        letter-spacing: 0.75px;
        border: calc(var(--spaceMini) / 2) solid var(--dangerBG);
        border-radius: 0;
    }
    .autocomplete {
        position: relative;
        display: inline-block;
    }
    .autocomplete-items {
        position: absolute;
        border: 0;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
        max-width: 800px;
    }
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        color: var(--whiteColor);
        background: var(--darkColor) !important;
        border-bottom: 1px solid #d4d4d4;
        height: 80px !important;
    }
    .autocomplete-items div:hover, .autocomplete-active {
        background: var(--dangerBG) !important;
    }
</style>

<div class="d-flex justify-content-start me-4">
    <select class="form-select select-group" aria-label="Default select example" id="method" style="width:300px;">
        <option value="GET">GET</option>
        <option value="POST">POST</option>
        <option value="PUT">PUT</option>
        <option value="DELETE">DELETE</option>
        <option value="PATCH">PATCH</option>
        <option value="HEAD">HEAD</option>
        <option value="OPTIONS">OPTIONS</option>
    </select>
    <input type="text" class="form-control py-3" id="endpoint_holder" placeholder="Search by url..." style="border: calc(var(--spaceMini) / 2) solid var(--dangerBG) !important;" aria-label="Text input with 2 dropdown buttons">
    <select class="form-select select-group" onchange="run_endpoint(this.value)" aria-label="Default select example" style="width:300px;">
        <option>-</option>
        <option value="send"><i class="fa-solid fa-floppy-disk"></i> Send</option>
        <option value="send_download"><i class="fa-solid fa-download"></i> Send & Download</option>
        <option value="send_share"><i class="fa-solid fa-cloud-arrow-up"></i> Send & Share</option>
    </select>
    <input hidden id="endpoint_id" value="">
</div>

<script>
    const method = document.getElementById('method').value

    function run_endpoint(type){
        const url = document.getElementById('endpoint_holder').value

        if(type == 'send'){
            send_endpoint(url, method)
        }
    }
    function send_endpoint(url, method){
        const response_box = document.getElementById('response_box')
        const status_code_box = document.getElementById('response_status_code')
        const time_box = document.getElementById('response_time')

        response_box.innerHTML = '... Loading ...'
        status_code_box.innerHTML = '...'
        time_box.innerHTML = '... ms'

        const startTime = performance.now()

        $.ajax({
            url: url,
            type: method,
            dataType: 'json',
            success: function(response, textStatus, jqXHR) {
                // Response body
                response_box.innerHTML = ''
                const beautifiedResponse = JSON.stringify(response, null, 4)
                const pre = document.createElement('pre')
                pre.textContent = beautifiedResponse

                // Status code
                const status = jqXHR.status
                let status_box_color = 'bg-success'
                if(status != '200'){
                    status_box_color = 'bg-danger'
                }
                status_code_box.innerHTML = `<span class='${status_box_color} px-3 ms-2 py-1 rounded-pill'>${status}</span>`

                // Time taken
                const endTime = performance.now()
                const timeTaken = endTime - startTime
                let time_box_color = 'bg-success'
                if(timeTaken >= 3000 ){
                    time_box_color = 'bg-danger'
                } else if (timeTaken >= 1000 ){
                    time_box_color = 'bg-warning'
                }
                time_box.innerHTML = `<span class='${time_box_color} px-3 ms-2 py-1 rounded-pill'>${timeTaken.toFixed(2)} ms</span>`
                
                // Environment
                const env = navigator.userAgent

                response_box.appendChild(pre)

                // Save endpoint
                check_endpoint_url(url)
                .then(data => {
                    let id = document.getElementById('endpoint_id').value

                    if(!data){
                        post_endpoint(method, url)
                    } 
                    post_response_history(id, status, method, timeTaken, JSON.stringify(response), env)
                })
                .catch(error => {
                    alert('API error:', error);
                })
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                // Do someting
            }
        })
    }
    function check_endpoint_url(url){
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/v1/project/endpoint/check',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({ endpoint_url: url}), 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response, textStatus, jqXHR) {
                    resolve(response.data)
                },
                error: function(response, jqXHR, textStatus, errorThrown) {
                    reject(errorThrown)
                }
            })
        })
    }
    function post_response_history(id, status, method, time, body, env){
        $.ajax({
            url: `http://127.0.0.1:8000/api/v1/project/response`,
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({ 
                endpoint_id: id,
                response_status: status,
                response_method: method,
                response_time: time,
                response_body: body,
                response_env: env
            }), 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response, textStatus, jqXHR) {
                get_list_history(id)
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                // Do someting
            }
        })
    }

    var endpoint = [];
    get_list_endpoint()
    function get_list_endpoint() {
        $.ajax({
                url: "http://127.0.0.1:8000/api/v1/project/endpoint/list",
                datatype: "json",
                type: "get",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                }
            })
            .done(function (response) {
                let data =  response.data;

                for(var i = 0; i < data.length; i++){
                    endpoint.push({
                        endpoint_url: data[i].endpoint_url,
                        endpoint_name: data[i].endpoint_name,
                        endpoint_method: data[i].endpoint_method
                    })
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                // Do someting
            });
        
    }

    function post_endpoint(method, url){
        $.ajax({
            url: 'http://127.0.0.1:8000/api/v1/project/endpoint',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({ 
                endpoint_url: url,
                endpoint_method: method,
                endpoint_name: null,
                endpoint_desc: null
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
    
    autocomplete(document.getElementById("endpoint_holder"), endpoint);
    function autocomplete(inp, arr) {
        var currentFocus

        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value
            closeAllLists()
            if (!val) { return false }
            currentFocus = -1
            a = document.createElement("DIV")
            a.setAttribute("id", this.id + "autocomplete-list")
            a.setAttribute("class", "autocomplete-items")
            this.parentNode.appendChild(a)
            for (i = 0; i < arr.length; i++) {
                if (arr[i].endpoint_url.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV")
                    b.innerHTML = `<strong>${arr[i].endpoint_url.substr(0, val.length)}</strong>
                        <span class='position-absolute' style='bottom:15px; left: 10px;'>
                            <span class='bg-warning px-3 py-1 me-2 rounded-pill'>${arr[i].endpoint_method}</span>
                            <span class='bg-success px-3 py-1 rounded-pill'>${arr[i].endpoint_name}</span>
                        </span>`
                    b.innerHTML += arr[i].endpoint_url.substr(val.length)
                    b.innerHTML += `<input type='hidden' value='${arr[i].endpoint_url}'>`
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value
                        closeAllLists()
                    })
                    a.appendChild(b)
                }
            }
        })

        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list")
            if (x) x = x.getElementsByTagName("div")
            if (e.keyCode == 40) {
                currentFocus++
                addActive(x)
            } else if (e.keyCode == 38) {
                currentFocus--
                addActive(x)
            } else if (e.keyCode == 13) {
                e.preventDefault()
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click()
                }
            }
        })

        function addActive(x) {
            if (!x) return false
            removeActive(x)
            if (currentFocus >= x.length) currentFocus = 0
            if (currentFocus < 0) currentFocus = (x.length - 1)
            x[currentFocus].classList.add("autocomplete-active")
        }

        function removeActive(x) {
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active")
            }
        }

        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items")
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i])
                }
            }
        }

        document.addEventListener("click", function (e) {
            closeAllLists(e.target)
        })
    }

</script>