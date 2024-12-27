<?php

declare(strict_types=1);

namespace JuanchoSL\Backups\Enums;

enum StrategyEnum
{
    case NUM_INCREMENTAL;
    case NUM_ROTATE;
    case DATE;
    case UNIQUE;

}