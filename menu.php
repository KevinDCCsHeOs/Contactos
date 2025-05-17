<nav>
    <?php if (isset($_SESSION["tipo"])): ?>
        <ul>
            <li><a href="tabcontactos.php" class="menu" style="background-color:rgb(252, 252, 252);"><?php echo ($_SESSION["tipo"] == "Administrador") ? "Todos los Contactos" : "Mis Contactos"; ?></a></li>
            <li><a href="tabusuarios.php" class="menu" style="background-color:rgb(252, 252, 252);"><?php echo ($_SESSION["tipo"] == "Administrador") ? "Administrar usuarios" : null; ?></a></li>
            
            <li><a href="logout.php" class="menu" style="background-color:rgb(252, 252, 252);">Cerrar Sesión</a></li>
        </ul>
    <?php else: ?>
        <ul>
            <li><a href="index.php" class="menu" style="background-color:rgb(252, 252, 252);">Iniciar Sesión</a></li>
        </ul>
    <?php endif; ?>
</nav>