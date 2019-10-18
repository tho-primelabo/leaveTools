<?php
//$this->load->view('templates/header');
?>
<div class="row">
    <div class="col-lg-12">
        <h2>DataTable using Codeigniter, MySQL and AJAX</h2>                 
    </div>
</div><!-- /.row -->
 
<div class="row">   
            <div class="col-lg-2">                                        
                <div class="form-group">
                    <input type="text" name="order_id" value="" class="form-control" id="filter-order-no" placeholder="Order No">
                </div>
            </div> 
            <div class="col-lg-2">   
                <div class="form-group">
                     <input type="text" name="name" value="" class="form-control" id="filter-name" placeholder="Name">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <input type="text" name="order_start_date" value="" class="form-control getDatePicker" id="order-start-date" placeholder="Start date">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <input type="text" name="order_end_date" value="" class="form-control getDatePicker" id="order-end-date" placeholder="End date">
                </div> 
            </div>
            <div class="col-lg-2">                                      
                <div class="form-group">
                    <button name="filter_order_filter" type="button" class="btn btn-primary btn-block" id="filter-order-filter" value="filter"><i class="fa fa-search fa-fw"></i></button>
                </div>
            </div>                                        
        </div>
        <div class="row">
        <div class="col-lg-12">      
        <div id="render-list-of-order">
        </div>
        </div>        
    </div>
    <div class="row">
    <div class="col-lg-12">       
        <a class="btn btn-info btn-xs" style="margin: 2px" href="https://techarise.com/"><i class="fa fa-mail-reply"></i> Tutorial</a>          
    </div>
</div><!-- /.row -->

<?php
//$this->load->view('templates/footer');
?>