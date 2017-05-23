<!DOCTYPE html>
<html>
    <title>Student Resume</title>
    <head><meta name=viewport content="width=device-width, initial-scale=1,user-scalable=no">
        <meta charset="utf8">
        <?php echo css_asset('bootstrap.min.css'); ?>
        <?php echo js_asset('jquery.min.js'); ?>
        <?php echo js_asset('bootstrap.min.js'); ?> 

    </head>

    <body>


        <br><br>
        <div class="container">
            <center>
                <h2>เลือกสาขาวิชาที่เรียน</h2>
            </center>

            <form method="post" action="<?php echo site_url('login/chk_login'); ?>">

                <div class="form-group" >
                    <input type="text" name="std_id" value="<?php echo $std_id;?>">
                   
                    <select class="form-control" id="fac_name" name="fac_name"  >
                        <option>--เลือกสาขาวิชาที่เรียน--</option>
                        <!-- ทำการวนลูบจากการส่งข้อมูลมาของfac_cl จาตาราง faculty -->
               <?php foreach ($rs->result() as $value) :?>
                                                       
                            <option value="<?php echo $value->major_id;?> "><?php echo $value->major_name;?></option>
                          <?php endforeach ?>  
                    
                    </select>
                
                </div>
                <br>
                <center>
                    <button type="submit" class="btn btn-success">&nbsp; ยืนยัน &nbsp;</button>
                </center>
            </form>

        </div>
        <br><br>


    </div>
</body>