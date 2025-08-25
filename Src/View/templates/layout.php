<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $viewData['title'] ?? 'Servicelance' ?></title>
    
    <?php if(!empty($data['pageCss'])): ?>
        <?php foreach($data['pageCss'] as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <header>
        <div class="container">
            <div class="flex">
                <div class="flex-col1">
                    
                </div>
            </div>
        </div>
    </header>
    
    <?php require $contentView; ?>

    <footer></footer>
    <?php if(!empty($data['pageJs'])): ?>
        <?php foreach($data['pageJs'] as $js): ?>
            </script src="<?= $js ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>