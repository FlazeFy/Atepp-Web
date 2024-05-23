<div class="d-flex justify-content-between">
    <div class="form-floating w-100">
        <select class="form-select" id="type_test" aria-label="Floating label select example">
            <option selected>-</option>
            <option value="1">Response Time : Must be ... than ...</option>
            <option value="2">Response Status : Must be equal to ...</option>
        </select>
        <label for="floatingSelect">Tests Snippet</label>
    </div>
    <div class="form-floating ms-2" style="width: 260px;">
        <select class="form-select" onchange="select_test(this)" aria-label="Floating label select example">
            <option selected>-</option>
            <option value="1">Add</option>
            <option value="2">Add & Edit</option>
            <option value="3">Add, Edit & Run</option>
        </select>
        <label for="floatingSelect">Add Snippet</label>
    </div>
</div>
<div id="test_holder"></div>

<style>
    .test-holder-box {
        margin: var(--spaceLG) 0;
    }
</style>

<script>
    function select_test(select){
        if(select.value == "1"){
            selected_test = $('#type_test').val()

            if(selected_test == "1"){
                $('#test_holder').append(`
                    <div class="test-holder-box">
                        <input hidden value="${selected_test}" id="test-type-holder">
                        <h6 class="fw-bold">Test #1</h6>
                        <div class="d-flex justify-content-start">
                            <h6 class="my-1">Response Time : Must be </h6>
                            <select id="test-param-1" class="form-select my-0 mx-1 py-0 px-1 text-center" style="width: 70px;" aria-label="Default select example">
                                <option value=">=">More</option>
                                <option value="<=">Less</option>
                            </select>
                            <h6 class="my-1 mx-1">Than</h6>
                            <input id="test-value-1" class="form-control my-0 mx-1 py-0 px-1 text-center" style="width: 90px;" type="number" min="1">
                            <h6 class="my-1"> ms</h6>
                        </div>
                        <div class="test-result-holder"></div>
                    </div>
                `)
            } else if(selected_test == "2"){
                $('#test_holder').append(`
                    <div class="test-holder-box">
                        <input hidden value="${selected_test}" id="test-type-holder">
                        <h6 class="fw-bold">Test #1</h6>
                        <div class="d-flex justify-content-start">
                            <h6 class="my-1">Response Status : Must be equal to </h6>
                            <input id="test-value-1" class="form-control my-0 mx-1 py-0 px-1 text-center" style="width: 90px;" type="number" min="100" max="999">
                        </div>
                        <div class="test-result-holder"></div>
                    </div>
                `)
            }
        }
    }
</script>