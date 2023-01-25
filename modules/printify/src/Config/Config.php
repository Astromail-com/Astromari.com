<?php

namespace Invertus\Printify\Config;

class Config
{
    const ACCESS_TOKEN = 'PRINTIFY_ACCESS_TOKEN';
    const REFRESH_TOKEN = 'PRINTIFY_REFRESH_TOKEN';
    const TOKEN_EXPIRE_DATE = 'PRINTIFY_TOKEN_EXPIRE_DATE';
    const ID_SHOP = 'PRINTIFY_ID_SHOP';
    const STATE_TOKEN = 'PRINTIFY_STATE_TOKEN';
    const ADMIN_DIR = 'PRINTIFY_ADMIN_DIR';
    const SEND_ORDER_ON_PAID = 'PRINTIFY_SEND_ORDER_ON_PAID';
    const LOG_STORAGE_DURATION = 'PRINTIFY_LOG_STORAGE_DURATION';

    const PRINTIFY_ORDER_PENDING = 'pending';
    const PRINTIFY_ORDER_ON_HOLD = 'on-hold';
    const PRINTIFY_ORDER_CHECKING_QUALITY = 'checking-quality';
    const PRINTIFY_ORDER_QUALITY_DECLINED = 'quality-declined';
    const PRINTIFY_ORDER_QUALITY_APPROVED = 'quality-approved';
    const PRINTIFY_ORDER_READY_FOR_PRODUCTION = 'ready-for-production';
    const PRINTIFY_ORDER_SENDING_TO_PRODUCTION = 'sending-to-production';
    const PRINTIFY_ORDER_IN_PRODUCTION = 'in-production';
    const PRINTIFY_ORDER_CANCELLED = 'canceled';
    const PRINTIFY_ORDER_FULFILLED = 'fulfilled';
    const PRINTIFY_ORDER_PARTIALLY_FULFILLED = 'partially-fulfilled';
    const PRINTIFY_ORDER_PAYMENT_NOT_RECEIVED = 'payment-not-received';
    const PRINTIFY_ORDER_CALLBACK_RECEIVED = 'callback-received';
    const PRINTIFY_ORDER_HAS_ISSUES = 'has-issues';
    const PRINTIFY_LAST_LOG_DELETE_DATE = 'last-delete-date';

    const PRINTIFY_LOG_STATUS_SUCCESS = 'success';
    const PRINTIFY_LOG_STATUS_FAILED = 'failed';
    const PRINTIFY_LOG_STATUS_LOG = 'log';

    const PRINTIFY_LOG_TYPE_PRODUCT = 'product';
    const PRINTIFY_LOG_TYPE_ORDER = 'order';
    const PRINTIFY_LOG_TYPE_ORDER_REQUEST = 'order-request';
    const PRINTIFY_LOG_TYPE_ORDER_WEBHOOK = 'order-webhook';
    const PRINTIFY_LOG_TYPE_PRODUCT_DATA = 'product-event-data';
    const PRINTIFY_LOG_TYPE_WEBHOOK = 'webhook';
    const PRINTIFY_LOG_TYPE_SHOP_DISCONNECT = 'shop-disconnect';

    const PRINTIFY_LOG_TYPE_IMAGE = 'image';
    const PRINTIFY_LOG_TYPE_CONNECTION_CHECK = 'connection_check';
    const PRINTIFY_LOG_TYPE_CONNECTION = 'connection';
    const PRINTIFY_LOG_DELETE_CHECK_INTERVAL_IN_DAYS = 1;

    public static function getPrintifyOrderStatuses()
    {
        return array(
            array(
                'id' => self::PRINTIFY_ORDER_PENDING,
                'name' => 'Pending',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_ON_HOLD,
                'name' => 'On hold',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_CHECKING_QUALITY,
                'name' => 'Checking quality',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_QUALITY_DECLINED,
                'name' => 'Quality declined',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_QUALITY_APPROVED,
                'name' => 'Quality approved',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_READY_FOR_PRODUCTION,
                'name' => 'Ready for production',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_SENDING_TO_PRODUCTION,
                'name' => 'Sending to production',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_IN_PRODUCTION,
                'name' => 'In production',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_CANCELLED,
                'name' => 'Cancelled',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_FULFILLED,
                'name' => 'Fulfilled',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_PARTIALLY_FULFILLED,
                'name' => 'Partially_fulfilled',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_PAYMENT_NOT_RECEIVED,
                'name' => 'No payment',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_CALLBACK_RECEIVED,
                'name' => 'Callback received',
            ),

            array(
                'id' => self::PRINTIFY_ORDER_HAS_ISSUES,
                'name' => 'Has issues',
            ),

        );
    }
}
