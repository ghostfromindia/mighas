<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "<?php echo e($key); ?>", // Enter the Key ID generated from the Dashboard
        "amount": "<?php echo e($order->total_final_price*100); ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "INR",
        "name": "<?php echo e(Auth::user()->full_name); ?>",
        "description": "<?php echo e($order->order_reference_number); ?>",
        "image": "<?php echo e(Key::get('site_logo')); ?>",
        "order_id": "<?php echo e($order_payment->id); ?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        "handler": function (response){
            //After Payment success
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('complete').click();
        },
        "prefill": {
            "name": "<?php echo e(Auth::user()->first_name); ?>",
            "email": "<?php echo e(Auth::user()->email); ?>",
            "contact": "<?php echo e(Auth::user()->phone_number); ?>"
        },
        "notes": {
            "address": ""
        },
        "theme": {
            "color": "#F37254"
        }
    };
    var rzp1 = new Razorpay(options);
    // document.getElementById('rzp-button1').onclick = function(e){
    //     rzp1.open();
    //     e.preventDefault();
    // }
    rzp1.open();
</script>
<form action="<?php echo e(url('checkout/payment/response')); ?>" method="post" hidden>
    <?php echo csrf_field(); ?>
    <input type="text" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="text" name="razorpay_order_id" id="razorpay_order_id">
    <input type="text" name="razorpay_signature" id="razorpay_signature">
    <input type="text" name="og" value="<?php echo e(encrypt($order->id)); ?>">
    <button type="submit" id="complete">Submit</button>
</form><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/checkout/payment.blade.php ENDPATH**/ ?>