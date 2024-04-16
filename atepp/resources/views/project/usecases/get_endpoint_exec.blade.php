<style>
    .form-select.select-group {
        background: var(--darkColor);
        font-weight: 600;
        font-size: var(--textXLG);
        letter-spacing: 0.75px;
        border: calc(var(--spaceMini) / 2) solid var(--dangerBG);
        border-radius: 0;
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
    <input type="text" class="form-control py-3" id="endpoint_holder" style="border: calc(var(--spaceMini) / 2) solid var(--dangerBG) !important;" aria-label="Text input with 2 dropdown buttons">
    <select class="form-select select-group" onchange="run_endpoint(this.value)" aria-label="Default select example" style="width:300px;">
        <option>-</option>
        <option value="send"><i class="fa-solid fa-floppy-disk"></i> Send</option>
        <option value="send_download"><i class="fa-solid fa-download"></i> Send & Download</option>
        <option value="send_share"><i class="fa-solid fa-cloud-arrow-up"></i> Send & Share</option>
    </select>
</div>

<script>
    function run_endpoint(type){
        const method = document.getElementById('method').value
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
                
                response_box.appendChild(pre)
            },
            error: function(response, jqXHR, textStatus, errorThrown) {
                
            }
        })
    }
</script>