<h1>نظام إدارة الإجازات والساعات الإضافية</h1>

<p>مرحباً بكم في نظام جوراني. إذا كنت موظفاً، يمكنك الان:</p>
<ul>
    <li><a href="<?php echo base_url();?>leaves/counters">مراجعة رصيد الإجازات.</a></li>
    <li><a href="<?php echo base_url();?>leaves">مراجعة قائمة طلبات الإجازات المرسلة من قبلك.</a></li>
    <li><a href="<?php echo base_url();?>leaves/create">طلب اجازة جديدة.</a></li>
</ul>

<br />

<p>اذا كنت المدير على موظف (أو موظفين)، يمكنك الان:</p>
<ul>
    <li><a href="<?php echo base_url();?>requests">مراجعة طلبات إجازات مقدمة اليك.</a></li>
    <?php if ($this->config->item('disable_overtime') == FALSE) { ?>
    <li><a href="<?php echo base_url();?>overtime">مراجعة طلبات ساعات إضافية مقدمة اليك.</a></li>
    <?php } ?>
</ul>
<br/>
<p>If you are an human resource or administrator, you could now:</p>
<ul>
    <li>See or calculate your <a href="<?php echo base_url();?>payslip">payslip</a>.</li>
    
</ul>
