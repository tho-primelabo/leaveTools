<?php
/**
 * This view displays the leave balance report.
 * @copyright  Copyright (c) 2014-2019 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.2.0
 */
?>

<h2><?php echo lang('project_index_title');?> &nbsp;</h2>


<div class="row-fluid">

    <div class="span12">

        <?php echo form_open_multipart('project/import'); ?>
        
            <div class="list-group">
            
            <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
            
            </div>

            <button type="submit" class="btn btn-primary">Import</button>

        <?php echo form_close(); ?>
        <div class="col-md-12">
                
                <a href="<?=base_url ()?>project/download/projects.xlsx" class="mdi mdi-file-excel-box">sample</a>
            </div>
        <div class="table-responsive" id="customer_data">
</div>

<script type="text/javascript">
     $(function() {
        <?php if ($this->config->item('csrf_protection') == true) {?>
            $.ajaxSetup({
                data: {
                    <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
                }
            });
            <?php }?>
    });
</script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/flick/jquery-ui.custom.min.css">
<script src="<?php echo base_url();?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<?php //Prevent HTTP-404 when localization isn't needed
if ($language_code != 'en') { ?>
<script src="<?php echo base_url();?>assets/js/i18n/jquery.ui.datepicker-<?php echo $language_code;?>.js"></script>
<?php } ?>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment-with-locales.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/js.state-2.2.0.min.js"></script>
<script type="text/javascript">

var entity = -1; //Id of the selected entity
var entityName = ''; //Label of the selected entity
var includeChildren = true;


$(document).ready(function() {
    
    load_data();
    function load_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>project/fetch",
            method:"GET",
            success:function(data){
                $('#customer_data').html(data);
            }
        })
    }$('#import_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"import",
                method:"POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    $('#file').val('');
                    load_data();
                    alert(data);
                }
            })
        });
    
});
</script>
