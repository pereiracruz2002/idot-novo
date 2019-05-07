<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/../header.php'); ?>

<div id="main-container">

    <div class="col-md-12">	
        <h3 class="headline m-top-md"><?= ucfirst($titulo) ?><span class="line"></span></h3>

        <?php
        if (validation_errors())
            print box_alert(validation_errors());
        if ($ok)
            print box_success('Dados salvos com sucesso!');
        ?>

        <?php echo $c->_call_pre_form($this->model, $data); ?>
        <div class="panel-body">
            <form action="<?= current_url() ?>" method="post" class="form-horizontal no-margin form-border" enctype="multipart/form-data">                
                <?php $c->_call_filter_pre_form($data); ?>
                <?php echo ($data ? $this->model->form($data[0]) : $this->model->form()) ?>
                <?php echo $c->_call_complemento_form($data)?>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input type="submit" value="Salvar" class="submit btn btn-primary" />
                    </div>
                </div>
            </form>
            <?php if (isset($data[0]['values']['estado'])): ?>
                <input type="hidden" id="estado_val" value="<?php echo $data[0]['values']['estado']; ?>" />
                <input type="hidden" id="cidade_val" value="<?php echo $data[0]['values']['cidade']; ?>" />
            <?php endif; ?>
        </div>
        <?= $c->_call_pos_form() ?>
    </div>
</div>

<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/../footer.php'); ?>
