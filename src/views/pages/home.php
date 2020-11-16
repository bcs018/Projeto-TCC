<?php $render('header'); ?>

<? print_r($dados); ?>

Opa, <?php foreach($lista as $dado):?>
    <p><?php echo $dado['nome_site']; ?></p>
<?php endforeach; ?>