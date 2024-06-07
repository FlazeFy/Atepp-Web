<div class="d-flex justify-content-between">
    <div class="form-floating w-100">
        <select class="form-select" id="type_test" aria-label="Floating label select example">
            <option selected>-</option>
            <option value="1">Response Time : Must be ... than ...</option>
            <option value="2">Response Status : Must be equal to ...</option>
            <option value="3">Response Object : Key ... must exist</option>
            <option value="4">Response Object : Key ... must be ...</option>
            <option value="5">Response Object : Key ... must contain value of these ...</option>
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
    .btn-test-value {
        background: var(--infoBG);
    }
    .btn-test-value:hover {
        background: var(--dangerBG);
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
            } else if(selected_test == "3"){
                $('#test_holder').append(`
                    <div class="test-holder-box">
                        <input hidden value="${selected_test}" id="test-type-holder">
                        <h6 class="fw-bold">Test #1</h6>
                        <div class="d-flex justify-content-start">
                            <h6 class="my-1">Response Object : Key </h6>
                            <input id="test-value-1" class="form-control my-0 mx-1 py-0 px-1 text-center" style="width: 200px;" type="text">
                            <h6 class="my-1">must exist</h6>
                        </div>
                        <div class="test-result-holder"></div>
                    </div>
                `)
            } else if(selected_test == "4"){
                $('#test_holder').append(`
                    <div class="test-holder-box">
                        <input hidden value="${selected_test}" id="test-type-holder">
                        <h6 class="fw-bold">Test #1</h6>
                        <div class="d-flex justify-content-start">
                            <h6 class="my-1">Response Object : Key </h6>
                            <input id="test-param-1" class="form-control my-0 mx-1 py-0 px-1 text-center" style="width: 200px;" type="text">
                            <h6 class="my-1">must be</h6>
                            <select id="test-value-1" class="form-select my-0 mx-1 py-0 px-1 text-center" style="width: 100px;" aria-label="Default select example">
                                <option value="null">Empty</option>
                                <option value="any">Filled</option>
                                <option value="string">String</option>
                                <option value="number">Number</option>
                                <option value="object">Object</option>
                                <option value="array">Array</option>
                                <option value="boolean">Boolean</option>
                            </select>
                        </div>
                        <div class="test-result-holder"></div>
                    </div>
                `)
            } else if(selected_test == "5"){
                $('#test_holder').append(`
                    <div class="test-holder-box">
                        <input hidden value="${selected_test}" id="test-type-holder">
                        <h6 class="fw-bold">Test #1</h6>
                        <div class="d-flex justify-content-start mb-2">
                            <h6 class="my-1">Response Object : Key </h6>
                            <input id="test-param-1" class="form-control my-0 mx-1 py-0 px-1 text-center" style="width: 200px;" type="text">
                            <h6 class="my-1">must contain value of these</h6>
                        </div>
                        <div id="test_5_item_show_value" class="border rounded py-2 px-0 ps-1" style="min-height: 30px;">
                            <a class='btn btn-socmed bg-success py-0 px-2 ms-2' data-bs-toggle="modal" data-bs-target="#add_contain_test_modal" title="Add Contain Value"><i class="fa-solid fa-plus"></i></a>
                            <div class="modal fade" id="add_contain_test_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Contain Value</h5>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="exampleInputEmail1" class="form-label text-white">Value</label>
                                            <input type="text" id="test_5_item_add_value" class="form-control" aria-describedby="emailHelp">
                                            <a class="error_input" id="test_5_add_value_msg"></a>
                                            <a class="btn btn-primary w-100 mt-2" onclick="test_5_add_value()">Add Value</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="test-result-holder"></div>
                    </div>
                `)
            }
        }
    }

    function test_5_add_value(){
        const val = $("#test_5_item_add_value").val()

        if(val != null && val.replace(" ", "") != ''){
            let found = false
            $(".test_5_value").each(function() {
                if($(this).val() == val){
                    found = true
                }   
            })

            if(!found){
                $("#test_5_item_show_value").prepend(`
                    <a class='btn btn-test-value py-0 ms-1' title="Click to remove">${val}<input hidden class="test_5_value" type="text" value="${val}"></a>
                `)
            } else {
                $("#test_5_add_value_msg").text(`Failed to add value. Its already on the list`)
            }
        }

        $("#test_5_item_add_value").val('')
    }
</script>