<div class="sidebar close">
    <div class="logo-details">
        <i class="fa-solid fa-globe"></i>
        <span class="logo_name"><img src="../logo2.png" alt=""></span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="lanzarAdmin">
                <i class='bx bxs-car'></i>
                <span class="link_name">LANZAR SERVICIO</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">LANZAR SERVICIO</a></li>
            </ul>
        </li>
        <!-- <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Category</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Category</a></li>
                <li><a href="#">HTML & CSS</a></li>
                <li><a href="#">JavaScript</a></li>
                <li><a href="#">PHP & MySQL</a></li>
            </ul>
        </li> -->
        <li>
            <a href="operadoresAdmin">
                <i class='bx bxs-user'></i>
                <span class="link_name">OPERADORES</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">OPERADORES</a></li>
            </ul>
        </li>
        <li>
            <a href="gruasAdmin">
                <i class='bx bxs-truck'></i>
                <span class="link_name">GRUAS/VEHICULOS</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">GRUAS/VEHICULOS</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class='bx bxs-gas-pump'></i>
                <span class="link_name">DIESEL</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">DIESEL</a></li>
            </ul>
        </li>
        <li>
            <!-- <a href="#">
                <i class="fa-solid fa-wrench"></i>
                <span class="link_name">TALLER</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">TALLER</a></li>
            </ul> -->
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <img src="../user.png" alt="profileImg">
                </div>
                <div class="name-job">
                    <div class="profile_name"><?php echo strtoupper($usuario); ?></div>
                    <div class="job"><?php echo strtoupper($permisos); ?></div>
                </div>
                <a href="../logout">
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
        </li>
    </ul>
</div>
