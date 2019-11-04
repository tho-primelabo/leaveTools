<?php if ($this->config->item('oauth2_enabled') == TRUE) { ?>
<script type="text/javascript" src="https://apis.google.com/js/client:platform.js?onload=start" async defer></script>
<script type="text/javascript">
    function start() {
        gapi.load('auth2', function() {
            auth2 = gapi.auth2.init({
                client_id: '<?php echo $this->config->item('oauth2_client_id'); ?>',
            });
        });
    }
</script>
<?php } ?>

<div class="page-wrap gradient-primary">
    <div class="container">
        <h1 class="logo"><a href="" title="Heroku">Heroku</a></h1>
        <div class="content">
            <div class="panel">
                <h3><?php echo lang('session_login_title'); ?></h3>
                <?php echo $flash_partial_view; ?>
                <?php echo validation_errors(); ?>
                <?php
                $attributes = array('id' => 'loginFrom');
                echo form_open('session/login', $attributes);
                $languages = $this->polyglot->nativelanguages($this->config->item('languages')); ?>

                <input type="hidden" name="last_page" value="session/login" />

                <div class="form-group">
                    <label for="login"><?php echo lang('session_login_field_login'); ?></label>
                    <div class="input-icon icon-username"></div>
                    <input type="text" autofocus="true" class="form-control" name="login" id="login" value="<?php echo (ENVIRONMENT == 'demo') ? 'bbalet' : set_value('login'); ?>" required tabindex="1">
                    <input type="hidden" name="CipheredValue" id="CipheredValue" />
                </div>
                <div class="form-group">
                    <input type="hidden" name="salt" id="salt" value="<?php echo $salt; ?>" />
                    <label for="password"><?php echo lang('session_login_field_password'); ?></label>
                    <div class="input-icon icon-password"></div>
                    <input autocomplete="off" class="form-control password" type="password" name="password" id="password" value="<?php echo (ENVIRONMENT == 'demo') ? 'bbalet' : ''; ?>" tabindex="2">
                </div>
                <button id="send" class="btn btn-primary btn-lg btn-block" name="commit" tabindex="3"><?php echo lang('session_login_button_login'); ?></button>
                <br />
                <?php if (count($languages) == 1) { ?>
                <input type="hidden" name="language" value="<?php echo $language_code; ?>" />
                <?php } else { ?>
                <label for="language"><?php echo lang('session_login_field_language'); ?></label>
                <select class="form-control" name="language" id="language">
                    <?php foreach ($languages as $lang_code => $lang_name) { ?>
                    <option value="<?php echo $lang_code; ?>" <?php if ($language_code == $lang_code) echo 'selected'; ?>><?php echo $lang_name; ?></option>
                    <?php } ?>
                </select>
                <?php } ?>
                <?php
                echo form_close();
                ?>
                <?php if (($this->config->item('ldap_enabled') == FALSE) && (ENVIRONMENT != 'demo')) { ?>
                <a class="panel-footer" id="cmdForgetPassword">Forget? &nbsp;<span><?php echo lang('session_login_button_forget_password'); ?></span></a>
                <?php } ?>
            </div>
            <?php if ($this->config->item('oauth2_enabled') == TRUE) { ?>
            <?php if ($this->config->item('oauth2_provider') == 'google') { ?>
            <a href="" id="cmdGoogleSignIn"><?php echo lang('session_login_button_login'); ?></a>
            <?php } ?>
            <?php } ?>
            <textarea id="pubkey" style="visibility:hidden;"><?php echo $public_key; ?></textarea>
        </div>
    </div>
</div>

<div class="modal hide" id="frmModalAjaxWait" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h1><?php echo lang('global_msg_wait'); ?></h1>
    </div>
    <div class="modal-body">
        <img src="<?php echo base_url(); ?>assets/images/loading.gif" align="middle">
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2-4.0.5/css/select2.min.css">
<script src="<?php echo base_url(); ?>assets/select2-4.0.5/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/js.state-2.2.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jsencrypt.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script type="text/javascript">
    //Encrypt the password using RSA and send the ciphered value into the form
    function submit_form() {
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey($('#pubkey').val());
        //Encrypt the concatenation of the password and the salt
        var encrypted = encrypt.encrypt($('#password').val() + $('#salt').val());
        $('#CipheredValue').val(encrypted);
        $('#loginFrom').submit();
    }

    //Attempt to authenticate the user using OAuth2 protocol
    function signInCallback(authResult) {
        if (authResult['code']) {
            $.ajax({
                url: '<?php echo base_url(); ?>session/oauth2',
                type: 'POST',
                data: {
                    auth_code: authResult.code
                },
                success: function(result) {
                    if (result == "OK") {
                        var target = '<?php echo $last_page; ?>';
                        if (target == '') {
                            window.location = "<?php echo base_url(); ?>";
                        } else {
                            window.location = target;
                        }
                    } else {
                        bootbox.alert(result);
                    }
                }
            });
        } else {
            // There was an error.
            bootbox.alert("Unknown OAuth2 error");
        }
    }

    $(function() {
        <?php if ($this->config->item('csrf_protection') == TRUE) { ?>
        $.ajaxSetup({
            data: {
                <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash(); ?>",
            }
        });
        <?php } ?>
        //Memorize the last selected language with a cookie
        if (Cookies.get('language') !== undefined) {
            var IsLangAvailable = 0 != $('#language option[value=' + Cookies.get('language') + ']').length;
            if (Cookies.get('language') != "<?php echo $language_code; ?>") {
                //Test if the former selected language is into the list of available languages
                if (IsLangAvailable) {
                    $('#language option[value="' + Cookies.get('language') + '"]').attr('selected', 'selected');
                    $('#loginFrom').prop('action', '<?php echo base_url(); ?>session/language');
                    $('#loginFrom').submit();
                }
            }
        }

        //Refresh page language
        $('#language').select2({
            width: '165px'
        });

        $('#language').on('select2:select', function(e) {
            var value = e.params.data.id;
            Cookies.set('language', value, {
                expires: 90,
                path: '/'
            });
            $('#loginFrom').prop('action', '<?php echo base_url(); ?>session/language');
            $('#loginFrom').submit();
        });

        $('#login').focus();

        $('#send').click(function() {
            submit_form();
        });

        //If the user has forgotten his password, send an e-mail
        $('#cmdForgetPassword').click(function() {
            alert($('#login').val());
            if ($('#login').val() == "") {
                bootbox.alert("<?php echo lang('session_login_msg_empty_login'); ?>");
            } else {
                alert('test 2');
                bootbox.confirm("<?php echo lang('session_login_msg_forget_password'); ?>",
                    "<?php echo lang('Cancel'); ?>",
                    "<?php echo lang('OK'); ?>",
                    function(result) {
                        if (result) {
                            $('#frmModalAjaxWait').modal('show');
                            $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>session/forgetpassword",
                                    data: {
                                        login: $('#login').val()
                                    }
                                })
                                .done(function(msg) {
                                    $('#frmModalAjaxWait').modal('hide');
                                    switch (msg) {
                                        case "OK":
                                            bootbox.alert("<?php echo lang('session_login_msg_password_sent'); ?>");
                                            break;
                                        case "UNKNOWN":
                                            bootbox.alert("<?php echo lang('session_login_flash_bad_credentials'); ?>");
                                            break;
                                    }
                                });
                        }
                    });
            }
        });

        //Validate the form if the user press enter key in password field
        $('#password').keypress(function(e) {
            if (e.keyCode == 13)
                submit_form();
        });

        //Alternative authentication methods
        <?php if ($this->config->item('oauth2_enabled') == TRUE) { ?>
        <?php if ($this->config->item('oauth2_provider') == 'google') { ?>
        $('#cmdGoogleSignIn').click(function() {
            auth2.grantOfflineAccess({
                'redirect_uri': 'postmessage'
            }).then(signInCallback);
        });
        <?php } ?>
        <?php } ?>

    });
</script>