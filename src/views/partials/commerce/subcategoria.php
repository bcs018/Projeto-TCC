<?php foreach($subs as $sub): ?>
    <!-- <li> --> <br>
        <!-- <a href=""> -->
            <?php
            for($q=0; $q<$level; $q++) echo "----";

            echo (!isset($edit)) ? " ".$sub['nome_cat'] : " ".$sub['nome_cat'].'.......[<a href="/admin/painel/editar-categoria/'.$sub['categoria_id'].'">Editar</a> | <a href="/admin/painel/excluir-categoria/action/'.$sub['categoria_id'].'">Excluir</a>]'; 
            ?>
        <!-- </a> -->
    <!-- </li> -->

<?php  
if(count($sub['subs'])>0){
    if(isset($edit)){
        $render('commerce/subcategoria', array(
            'subs' => $sub['subs'],
            'level' => $level + 1,
            'edit' => 1
        ));
    }else{
        $render('commerce/subcategoria', array(
            'subs' => $sub['subs'],
            'level' => $level + 1
        ));
    }
}
?>
<?php endforeach; ?>