<ul class="nav">
    <li class="nav-item">
        <a class="nav-link tabs" aria-current="page" href="#">Params</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" onclick="navigate_tab('authorization')">Authorization</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" href="#">Headers (8)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" href="#">Body</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" href="#">Script</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" href="#">Tests</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" href="#">Dummy</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" href="#">Docs</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" onclick="navigate_tab('history')">History</a>
    </li>
    <li class="nav-item">
        <a class="nav-link tabs" href="#"><i class="fa-solid fa-gear"></i></a>
    </li>
</ul>
<script>
    navigate_tab()
    function navigate_tab(tab){
        $(`#tabs_${tab}`).css({
            'display':'block'
        })
    }
</script>