<?php

if (!function_exists('getOrderStatusColor')) {
    function getOrderStatusColor($status) {
        return match($status) {
            'Pending' => 'secondary',
            'Processing' => 'warning',
            'Shifted' => 'info',
            'Delivered' => 'success',
            'Cancelled' => 'danger',
            default => 'secondary',
        };
    }
}

if (!function_exists('getPaymentStatusColor')) {
    function getPaymentStatusColor($status) {
        return match($status) {
            'Pending' => 'warning',
            'Paid' => 'info',
            'Delivered' => 'success',
            default => 'secondary',
        };
    }
}
