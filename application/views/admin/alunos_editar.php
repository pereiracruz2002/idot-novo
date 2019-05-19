<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="content">
    <div id="main-container">
        <div class="col-md-12">	
            <h3 class="headline m-top-md">Editar Alunos<span class="line"></span></h3>
            <div class="panel-body">
                <?php if(isset($show_popup)):?>
                 <div class="alert alert-danger text-center" role="alert">
                    Alteração de dados realizada com sucesso!
                </div>
                <?php endif;?>
                <form action="<?php base_url();?>/admin/alunos/editar_dados" method="post" class="form-horizontal no-margin form-border" enctype="multipart/form-data">
                    <?php echo $form;?>      
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input type="submit" value="Salvar" class="submit btn btn-primary" />
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
 <?php include_once(dirname(__FILE__) . '/footer.php'); ?> 
