<nav class="navbar navbar-expand-lg navbar-light py-3">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/"><i class="fa-solid fa-meteor"></i> Atepp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if($active_page == 'dashboard'){ echo"active"; }?>" aria-current="page" href="/dashboard"><?php if($active_page == 'dashboard'){ echo"/"; }?>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($active_page == 'project'){ echo"active"; }?>" aria-current="page" href="/project"><?php if($active_page == 'project'){ echo"/"; }?>Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($active_page == 'workingspace'){ echo"active"; }?>" aria-current="page" href="/workingspace"><?php if($active_page == 'workingspace'){ echo"/"; }?>WorkingSpace</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($active_page == 'dummy'){ echo"active"; }?>" aria-current="page" href="/dummy"><?php if($active_page == 'dummy'){ echo"/"; }?>Dummy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($active_page == 'global'){ echo"active"; }?>" aria-current="page" href="/global"><?php if($active_page == 'global'){ echo"/"; }?>Global</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @flazey <span class="user-category enterprise"><i class="fa-solid fa-crown"></i> Enterprise</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/profile">My Profile</a></li>
                        <li><a class="dropdown-item" href="/social">Social</a></li>
                        <li><a class="dropdown-item" href="/about">About Us</a></li>
                        <li><a class="dropdown-item" href="/feedback">Feedback</a></li>
                        <li><a class="dropdown-item" href="/help">Help Center</a></li>
                        <li><hr class="dropdown-divider bg-light mt-0"></li>
                        <li class="px-2"><a class="dropdown-item bg-danger text-white rounded py-2" href="#"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out</a></li>
                    </ul>
                </li>
            </ul>
            <form class="position-relative" style="width:35vw;">
                <input class="form-control py-3" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success position-absolute" style="right: var(--spaceSM); top: var(--spaceSM);" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </div>
</nav>