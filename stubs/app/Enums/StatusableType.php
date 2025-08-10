<?php

namespace App\Enums;

use App\Models\User;

enum StatusableType: string
{
	case User = User::class;
}
