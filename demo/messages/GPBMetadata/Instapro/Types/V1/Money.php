<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instapro/types/v1/money.proto

namespace GPBMetadata\Instapro\Types\V1;

class Money
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
x
instapro/types/v1/money.protoinstapro.types.v1"<
Money
currency_code (	
units (
nanos (bproto3'
        , true);

        static::$is_initialized = true;
    }
}

