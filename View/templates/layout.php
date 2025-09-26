<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $viewData['title'] ?? 'Budgetlance' ?></title>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap"></noscript>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet';">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"></noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <?php if(!empty($viewData['pageCss'])): ?>
    <?php foreach($viewData['pageCss'] as $css): ?>
    <link rel="stylesheet" href="<?= $css ?>">
    <?php endforeach; ?>
    <?php endif; ?>
    <link rel="stylesheet" href="<?= CSS_TEMPLATE_URL . "layout.css" ?>">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="flex">
                <div class="flex-col1">
                    <a href="/" class="headerLogo" title="Pagina Inicial">
                        <img src="<?= IMAGES_TEMPLATE_URL . "Budgetlancelogo.png" ?>" alt="logo Budgetlance">
                    </a>
                </div>
                <div class="flex-col2">
                    <a href="javascript:showMenu()" class="header-menu" id="header-menu">
                        <i class="fas fa-bars" id="fa-bars"></i>
                    </a>
                    <nav class="header-nav" id="header-nav">
                        <ul class="nav-ul">
                            <li class="nav-li">
                                <a href="/home" class="nav-btn" title="Pagina Inicial">
                                    Home
                                </a>
                            </li>
                            <?php if(!isset($_SESSION['logado'])): ?>
                            <li class="nav-li">
                                <a href="/login" class="nav-btn" title="Fazer Login">
                                    Login
                                </a>
                            </li>
                            <li class="nav-li">
                                <a href="/signUp" class="nav-btn" title="Se cadastrar">
                                    Sign Up
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(isset($_SESSION['logado'])): ?>
                            <li class="nav-li">
                                <div class="dropdown-container">
                                    <a href="javascript:showDropdown()" class="user-menu" id="user-menu" title="Menu do usuario">
                                        <?php
                                            // Obtém a hora atual para definir a saudação
                                            date_default_timezone_set("America/Sao_Paulo");
                                            $hour = date('H');
                                            $greeting = "Olá";

                                            // Define a saudação com base na hora do dia
                                            if ($hour >= 5 && $hour < 12) {
                                                $greeting = "Bom dia";
                                            } else if ($hour >= 12 && $hour < 18) {
                                                $greeting = "Boa tarde";
                                            } else {
                                                $greeting = "Boa noite";
                                            }

                                            $usuario = $_SESSION['logado'];
                                            
                                            $userName = isset($_SESSION['logado']) ? htmlspecialchars($usuario->getNomeUsuario()) : "Usuário";

                                            // Exibe a saudação e o nome do usuário
                                            echo $greeting . ", " . $userName . "!";
                                        ?>
                                        <span class="dropdown-arrow">&#9660</span> 
                                        <!-- esse trecho no span é referente a um caracter de seta apontando pra baixo, usado assim para não precisar de uma imagem para representar essa seta. -->

                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="/perfil">Perfil</a>
                                        </li>
                                        <li>
                                            <a href="/dashboard">Dashboard Principal</a>
                                        </li>
                                        <li>
                                            <a href="/dashboard/cliente">Clientes</a>
                                        </li>
                                        <li>
                                            <a href="/dashboard/servico">Categoria de Serviços</a>
                                        </li>
                                        <li>
                                            <a href="/login/logout" id="lastBtn">Sair</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    
    <?php require $contentView; ?>

    <footer class="footer">
        <div class="footerClass">
            <p>
                <a href="/" title="Pagina Inicial">
                    <img src="<?= IMAGES_TEMPLATE_URL . "Budgetlancelogo.png" ?>" alt="logo Budgetlance">
                </a>
            </p>
            
            <p class="description">
                © Budgetlance 2025
            </p>
        </div>
    </footer>
    <?php if(!empty($viewData['pageJs'])): ?>
    <?php foreach($viewData['pageJs'] as $js): ?>
    <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>
    <script src="<?= JS_TEMPLATE_URL . "layout.js" ?>"></script>
    <script>


        function showMenu() {
            let bars = document.getElementById('fa-bars');
            bars.classList.toggle("active");

            let menu = document.querySelector('.header-nav');
            menu.classList.toggle("active");
        }

        function showDropdown() {
            let dropdown = document.querySelector('.dropdown-container');
            dropdown.classList.toggle("active");
        }

        
    </script>
</body>
</html>