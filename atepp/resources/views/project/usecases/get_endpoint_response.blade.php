<style>
    #response_box {
        color: var(--whiteColor);
        font-size: var(--textMD);
    }
</style>

<div class="container w-100 p-3 position-absolute" style="min-height:75vh;">
    <div class="row">
        <div class="col">
            <div class="tabs_content_holder" id="tabs_authorization" style="display:none;">
                @include('project.usecases.get_authorization')
            </div>
            <div class="tabs_content_holder" id="tabs_history" style="display:none;">
                @include('project.usecases.get_history')
            </div>
            <div class="tabs_content_holder" id="tabs_tests" style="display:none;">
                @include('project.usecases.get_tests')
            </div>
        </div>
        <div class="col bg-response-body">
            <h1 class="fw-bold">Response <span id="response_status_code"></span> <span id="response_time"></span></h1>
            <div id="response_box"></div>
        </div>
    </div>
</div>