<?php

namespace App\Enums;

enum VisibilityEnum: string
{
    const PUBLIC = 'public';
    const UNLISTED = 'unlisted';
    const PRIVATE = 'private';
}