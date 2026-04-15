<?php

namespace App\Enums;

enum HttpStatusCode: int
{
    case BAD_REQUEST          = 400;
    case NOT_FOUND            = 404;
    case UNPROCESSABLE_ENTITY = 422;
}
