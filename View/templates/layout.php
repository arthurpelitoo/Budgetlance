<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $viewData['title'] ?? 'Servicelance' ?></title>
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
                        <i class="fas fa-bars"></i>
                    </a>
                    <nav class="header-nav" id="header-nav">
                        <ul class="nav-ul">
                            <li class="nav-li">
                                <a href="/home" class="nav-btn" title="Pagina Inicial">
                                    Home
                                </a>
                            </li>
                            <li class="nav-li">
                                <a href="/sobre" class="nav-btn" title="Sobre">
                                    Sobre
                                </a>
                            </li>
                            <li class="nav-li">
                                <a href="/dashboard" class="nav-btn" title="Pagina Inicial">
                                    Dashboard Gerenciador
                                </a>
                            </li>
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
    <script>
        function showMenu() {
            let menu = document.querySelector('.header-nav');
            menu.classList.toggle("active");
        }
    </script>
</body>
</html>