<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="content">
    <div id="main-container">

        <div class="col-md-12">	
            <h3 class="headline m-top-md"><?= ucfirst($titulo) ?><span class="line"></span></h3>

            <div class="panel-body">
                <form action="<?= site_url($action); ?>" method="post" class="form-horizontal no-margin form-border" enctype="multipart/form-data">             
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $form0;?>
                                </div>

                                <div class="col-md-6">
                                    <?php echo $form1;?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $form2;?>
                                </div> 
                            </div>
                            <?php if(isset($agenda_id)):?>
                                <input type="hidden" name="agenda_id" value="<?php echo $agenda_id;?>" />
                            <?php endif;?>
                            
                            <input type="submit" value="Salvar" class="submit btn btn-primary" />
                        </div>
                    </div>
                </form>
               
            </div>
        </div>
    </div>
</div>

<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/footer.php'); ?>
