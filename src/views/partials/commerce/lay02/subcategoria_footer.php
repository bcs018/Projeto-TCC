<?php foreach($subs as $sub): ?>
    <li>
        <a href="/produtos/categoria/<?php echo $sub['categoria_id'] ?>">
            <?php
            //for($q=0; $q<$level; $q++) echo "";

            echo $sub['nome_cat']; 
            ?>
        </a>
    </li>

<?php  
if(count($sub['subs'])>0){
    $render('commerce/lay01/subcategoria_footer', array(
        'subs' => $sub['subs'],
        'level' => $level + 1,
    ));
}
?>
<?php endforeach; ?> 