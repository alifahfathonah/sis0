<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>S01_sklh List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Kode</th>
		<th>Nama</th>
		
            </tr><?php
            foreach ($s01_sklh_data as $s01_sklh)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $s01_sklh->Kode ?></td>
		      <td><?php echo $s01_sklh->Nama ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>