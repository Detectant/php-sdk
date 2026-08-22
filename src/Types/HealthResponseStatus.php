<?php

namespace Detectant\Types;

enum HealthResponseStatus: string
{
    case Ok = "ok";
    case Degraded = "degraded";
}
