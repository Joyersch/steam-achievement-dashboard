<?php

namespace App\Enums;

enum ActivityType: int
{
    case AchievementGained = 0;
    case AchievementLost = 1;
    case GameAchievementAdded = 2;
    case GameAchievementRemoved = 3;
}
