<?php

namespace Bigeweb\Authentication\Enums;

enum RegisterStatusEnum : string
{
    CASE Active = 'active';
    CASE Inactive = 'inactive';
    CASE Suspended = 'suspended';
    CASE Pending = 'pending';
    CASE Closed = 'closed';
}