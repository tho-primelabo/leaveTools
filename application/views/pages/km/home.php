<h1>ប្រពន្ធ័គ្រប់គ្រងការសុំច្បាប់</h1>

<p>សូមស្វាគមន៍មកកាន់ ប្រព័ន្ធគ្រប់គ្រងការសុំច្បាប់។ ប្រសិនបើលោកអ្នកជាបុគ្គលិក ឥឡូវនេះលោកអ្នកនឹងអាចៈ</p>
<ul>
    <li><a href="<?php echo base_url();?>leaves/counters">មើលតុល្យការ ថ្ងៃឈប់សម្រាក់របស់អ្នក។</a>.</li>
    <li><a href="<?php echo base_url();?>leaves">មើលបញ្ជីសំណើរសុំច្បាប់ដែលលោកអ្នកស្នើសុំ។</a>.</li>
    <li><a href="<?php echo base_url();?>leaves/create">ស្នើសុំច្បាប់ឈប់សម្រាក់ថ្មី។</a>.</li>
</ul>

<br />

<p>ប្រសិនបើលោកអ្នកជាអ្នកគ្រប់គ្រងបុគ្គលិកផ្សេងទៀត ឥឡូវនេះលោកអ្នកនឹងអាចៈ</p>
<ul>
    <li><a href="<?php echo base_url();?>requests">វាយតំលៃការសុំច្បាប់ដែលបានផ្ញើរទៅកាន់អ្នក។</a>.</li>
    <?php if ($this->config->item('disable_overtime') == FALSE) { ?>
    <li><a href="<?php echo base_url();?>overtime">វាយតំលៃការបន្ថែមម៉ោងដែលបានផ្ញើរទៅកាន់អ្នក។</a>.</li>
    <?php } ?>
</ul>
<br/>
<p>If you are an human resource or administrator, you could now:</p>
<ul>
    <li>See or calculate your <a href="<?php echo base_url();?>payslip">payslip</a>.</li>
    
</ul>
