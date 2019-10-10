<?php
CI_Controller::get_instance()->load->helper('language');
$this->lang->load('menu', $language);
?>

<?php if ($this->config->item('ldap_enabled') === false) {?>
<div id="frmChangeMyPwd" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3><?php echo lang('menu_password_popup_title'); ?></h3>
  </div>
  <div class="modal-body" id="frmChangeMyPwdBody">
    <img src="<?php echo base_url(); ?>assets/images/loading.gif">
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal"><?php echo lang('menu_password_popup_button_cancel'); ?></button>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    //Popup change password
    $("#cmdChangePassword").click(function() {
      $("#frmChangeMyPwd").modal('show');
      $("#frmChangeMyPwdBody").load('<?php echo base_url(); ?>users/reset/<?php echo $user_id; ?>');
    });

  });
</script>
<?php }?>

<div id="wrap">
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <a href="<?php echo base_url(); ?>home" class="brand">&nbsp;<img src="<?php echo base_url(); ?>assets/images/brand.png" height="20" width="20" style="margin-top:-6px;"></a>
      <div class="nav-responsive">
        <ul class="nav">
          <li><a href="<?php echo base_url(); ?>leaves" title="<?php echo lang('menu_leaves_list_requests'); ?>"><i class="mdi mdi-format-list-bulleted"></i></a></li>

          <?php if ($is_admin == true) {?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_admin_title'); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url(); ?>users"><?php echo lang('menu_admin_list_users'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>users/create"><?php echo lang('menu_admin_add_user'); ?></a></li>
              <li class="divider"></li>
              <li class="nav-header"><?php echo lang('menu_hr_leaves_type_divider'); ?></li>
              <li><a href="<?php echo base_url(); ?>leavetypes"><?php echo lang('menu_hr_list_leaves_type'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>contracttypes"><?php echo lang('menu_hr_list_contracts_type'); ?></a></li>
              <li class="divider"></li>
              <li class="nav-header"><?php echo lang('menu_admin_settings_divider'); ?></li>
              <li><a href="<?php echo base_url(); ?>admin/diagnostic"><?php echo lang('menu_admin_diagnostic'); ?></a></li>
              <?php if ($is_admin == true) {?>
              <li><a href="<?php echo base_url(); ?>admin/settings"><?php echo lang('menu_admin_settings'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>admin/oauthclients"><?php echo lang('menu_admin_oauth_clients'); ?></a></li>
              <?php }?>
            </ul>
          </li>
          <?php }?>

          <?php if ($is_hr == true) {?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_hr_title'); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="nav-header"><?php echo lang('menu_hr_employees_divider'); ?></li>
              <li><a href="<?php echo base_url(); ?>hr/employees"><?php echo lang('menu_hr_list_employees'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>organization"><?php echo lang('menu_hr_list_organization'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>payslip"><?php echo lang('menu_hr_list_payslip'); ?></a></li>
              <li class="divider"></li>
              <li class="nav-header"><?php echo lang('menu_hr_contracts_divider'); ?></li>
              <li><a href="<?php echo base_url(); ?>contracts"><?php echo lang('menu_hr_list_contracts'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>positions"><?php echo lang('menu_hr_list_positions'); ?></a></li>
               <li><a href="<?php echo base_url(); ?>rooms"><?php echo lang('menu_hr_list_rooms'); ?></a></li>
              <li class="divider"></li>
              <li class="nav-header"><?php echo lang('menu_hr_reports_divider'); ?></li>
              <li><a href="<?php echo base_url(); ?>reports/balance"><?php echo lang('menu_hr_report_leave_balance'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>reports/leaves"><?php echo lang('menu_hr_report_leaves'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>reports"><?php echo lang('menu_hr_reports_divider'); ?></a></li>
            </ul>
          </li>
          <?php }?>

          <?php if ($is_manager == true) {?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php echo lang('menu_validation_title'); ?>&nbsp;
              <?php if ($requests_count > 0) {?>
              <span class="badge badge-warning"><?php echo $requests_count; ?></span>
              <?php }?>
              &nbsp;<b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url(); ?>requests/delegations"><?php echo lang('menu_validation_delegations'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>requests/collaborators"><?php echo lang('menu_validation_collaborators'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>requests/balance"><?php echo lang('menu_hr_report_leave_balance'); ?></a></li>
              <li class="divider"></li>
              <li class="nav-header"><?php echo lang('menu_validation_title'); ?></li>
              <li><a href="<?php echo base_url(); ?>requests">
                  <?php if ($requested_leaves_count > 0) {?>
                  <span class="badge badge-info"><?php echo $requested_leaves_count; ?></span>
                  <?php }?>
                  <?php echo lang('menu_validation_leaves'); ?></a></li>
              <?php if ($this->config->item('disable_overtime') === false) {?>
              <li><a href="<?php echo base_url(); ?>overtime">
                  <?php if ($requested_extra_count > 0) {?>
                  <span class="badge badge-info"><?php echo $requested_extra_count; ?></span>
                  <?php }?>
                  <?php echo lang('menu_validation_overtime'); ?></a></li>
              <?php }?>
            </ul>
          </li>
          <?php }?>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_requests_title'); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="nav-header"><?php echo lang('menu_requests_leaves'); ?></li>
              <li><a href="<?php echo base_url(); ?>leaves/counters"><?php echo lang('menu_leaves_counters'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>leaves"><?php echo lang('menu_leaves_list_requests'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>leaves/create"><?php echo lang('menu_leaves_create_request'); ?></a></li>
              <?php if ($this->config->item('disable_overtime') === false) {?>
              <li class="divider"></li>
              <li class="nav-header"><?php echo lang('menu_requests_overtime'); ?></li>
              <li><a href="<?php echo base_url(); ?>extra"><?php echo lang('menu_requests_list_extras'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>extra/create"><?php echo lang('menu_requests_request_extra'); ?></a></li>
              <?php }?>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_calendar_title'); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url(); ?>calendar/individual"><?php echo lang('menu_calendar_individual'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>calendar/year"><?php echo lang('menu_calendar_year'); ?></a></li>
              <?php if ($this->config->item('disable_workmates_calendar') == false) {?>
              <li><a href="<?php echo base_url(); ?>calendar/workmates"><?php echo lang('menu_calendar_workmates'); ?></a></li>
              <?php }?>
              <?php if ($is_manager == true) {?>
              <li><a href="<?php echo base_url(); ?>calendar/collaborators"><?php echo lang('menu_calendar_collaborators'); ?></a></li>
              <?php }?>
              <?php if (($is_hr == true) || ($is_admin == true) || ($this->config->item('hide_global_cals_to_users') === false)) {?>
              <?php if ($this->config->item('disable_department_calendar') == false) {?>
              <li><a href="<?php echo base_url(); ?>calendar/department"><?php echo lang('menu_calendar_department'); ?></a></li>
              <?php }?>
              <li><a href="<?php echo base_url(); ?>calendar/organization"><?php echo lang('menu_calendar_organization'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>calendar/tabular"><?php echo lang('menu_calendar_tabular'); ?></a></li>
              <?php }?>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_booking_department'); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <?php
                if (isset($rooms)) {
                    foreach ($rooms as $room): ?>
                              <li><a href="<?php echo base_url(); ?>booking/<?php $room['id']?>"><?php echo $room['name']; ?></a>
                              <?php endforeach;
                }?>
                </li>
              </ul>
            </li>

          <li>
            <form class="navbar-form pull-left">
              <a class="btn btn-warning" href="<?php echo base_url(); ?>leaves/create"><b><?php echo lang('menu_leaves_request_button'); ?></b></a>
            </form>
          </li>
        </ul>

        <ul class="nav pull-right">
          <a href="<?php echo base_url(); ?>users/myprofile" class="brand"><?php echo $fullname; ?></a>
          <li><a href="<?php echo base_url(); ?>users/myprofile" title="<?php echo lang('menu_banner_tip_myprofile'); ?>"><i class="mdi mdi-account-box-outline"></i></a></li>
          <?php if ($this->config->item('ldap_enabled') === false && $this->config->item('saml_enabled') === false) {?>
          <li><a href="#" id="cmdChangePassword" title="<?php echo lang('menu_banner_tip_reset'); ?>"><i class="mdi mdi-lock"></i></a></li>
          <?php }
$urlLogout = 'session/logout';
if ($this->config->item('saml_enabled') === true) {
    $urlLogout = 'api/slo';
}?>
          <li><a href="<?php echo base_url() . $urlLogout; ?>" title="<?php echo lang('menu_banner_logout'); ?>"><i class="mdi mdi-logout"></i></a></li>
        </ul>
      </div>
    </div>
  </div><!-- /.navbar -->

  <div class="container-fluid">
    <br />
    <div class="row-fluid">
      <div class="span12">&nbsp;</div>
    </div>