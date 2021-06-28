<?php foreach($subs as $sub): ?>
    <!-- <li> --> <br>
        <!-- <a href=""> -->
            <?php
            for($q=0; $q<$level; $q++) echo "----";
            echo " ".$sub['nome_cat']; 
            ?>
        <!-- </a> -->
    <!-- </li> -->

<?php  
if(count($sub['subs'])>0){
    $render('commerce/subcategoria', array(
        'subs' => $sub['subs'],
        'level' => $level + 1
    ));
}
?>
<?php endforeach; ?>