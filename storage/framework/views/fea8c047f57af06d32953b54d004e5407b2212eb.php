<?php $__env->startSection('body'); ?>
    <!-- module 6 -->
    <table data-module="module-6" data-thumb="thumbnails/06.png" width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
        <tr>
            <td data-bgcolor="bg-module" bgcolor="#eaeced">
                <table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td data-bgcolor="bg-block" class="holder" style="padding:64px 60px 50px;" bgcolor="#f9f9f9">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:0 0 20px;">
                                        <table width="232" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td  align="center">
                                                    <a target="_blank" href="<?php echo e(URL::to('/')); ?>"><img src="<?php echo e(Key::get('site_logo')); ?>" alt="" width="150px"></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-color="title" data-size="size title" data-min="20" data-max="40" data-link-color="link title color" data-link-style="text-decoration:none; color:#292c34;" class="title" align="center" style="font:30px/33px Arial, Helvetica, sans-serif; color:#292c34; padding:0 0 23px;">

                                        <?php
                                        print_r($text);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-color="text" data-size="size text" data-min="10" data-max="26" data-link-color="link text color" data-link-style="font-weight:bold; text-decoration:underline; color:#40aceb;" align="center" style="font:16px/29px Arial, Helvetica, sans-serif; color:#888; padding:0 0 21px;">
                                        
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr><td height="28"></td></tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- module 7 -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client.mails.email_base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/client/mails/message.blade.php ENDPATH**/ ?>