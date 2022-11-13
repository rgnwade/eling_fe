<?php

Route::post('notification-midtrans', 'NotificationController@midtrans')->name('notification.midtrans');
Route::get('order-payment-midtrans/{order_payment_id}', 'OrderPaymentController@payment_midtrans')->name('order.payment.midtrans');
