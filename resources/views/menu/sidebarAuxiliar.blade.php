<div class="sidebar-inner">
    <!-- ### $Sidebar Header ### -->
    <div class="sidebar-logo">
        <div class="peers ai-c fxw-nw">
        <div class="peer peer-greed">
            <a class="sidebar-link td-n" href="#">
            <div class="peers ai-c fxw-nw">
                <div class="peer">
                <div class="logo">
                    <img src="public/assets/static/images/logo.png" alt="">
                </div>
                </div>
                <div class="peer peer-greed">
                <h5 class="lh-1 mB-0 logo-text">CEOP</h5>
                </div>
            </div>
            </a>
        </div>
        <div class="peer">
            <div class="mobile-toggle sidebar-toggle">
            <a href="" class="td-n">
                <i class="ti-arrow-circle-left"></i>
            </a>
            </div>
        </div>
        </div>
    </div>

    <!-- ### $Sidebar Menu ### -->
    <ul class="sidebar-menu scrollable pos-r">
        <li class="nav-item mT-30 actived">
            <a class="sidebar-link" href="#" @@click="menu=0">
            <span class="icon-holder">
                <i class="c-blue-500 ti-home"></i>
            </span>
            <span class="title">Inicio</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="#">
                <span class="icon-holder">
                <i class="c-orange-500 el-icon-user"></i>
                </span>
                <span class="title">Miembros</span>
                <span class="arrow">
                <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class='sidebar-link' href="#" @click="menu=1">Miembros</a>
                </li>
                <!-- <li>
                    <a class='sidebar-link' href="#" @click="menu=2">Categorías</a>
                </li> -->
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="#">
                <span class="icon-holder">
                    <i class="c-purple-500 el-icon-s-custom"></i>
                </span>
                <span class="title">Grupos</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" @click="menu=2">Grupos</a>
                </li>
                <!-- <li>
                    <a href="#" @click="menu=4">Proveedores</a>
                </li> -->
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="#">
                <span class="icon-holder">
                    <i class="c-black-500 el-icon-thumb"></i>
                </span>
                <span class="title">Ministerios</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" @click="menu=3">Ministerios</a>
                </li>
                <!-- <li>
                    <a href="vector-maps.html">Vector Map</a>
                </li> -->
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="#">
                <span class="icon-holder">
                    <i class="c-red-500 el-icon-refresh"></i>
                </span>
                <span class="title">Visitantes</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" @click="menu=4">Visitantes</a>
                </li>
                <!-- <li>
                    <a href="vector-maps.html">Vector Map</a>
                </li> -->
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="#">
                <span class="icon-holder">
                    <i class="c-red-500 el-icon-first-aid-kit"></i>
                </span>
                <span class="title">Decesos</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" @click="menu=6">Decesos</a>
                </li>
                <!-- <li>
                    <a href="vector-maps.html">Vector Map</a>
                </li> -->
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="#">
                <span class="icon-holder">
                    <i class="c-yellow-500 el-icon-folder-opened"></i>
                </span>
                <span class="title">Reportes</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" @click="menu=7">Reportes</a>
                </li>
                <!-- <li>
                    <a href="vector-maps.html">Vector Map</a>
                </li> -->
            </ul>
        </li>
    </ul>
    </div>