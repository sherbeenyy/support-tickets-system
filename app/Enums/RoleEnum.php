<?php

namespace App\Enums;

enum RoleEnum: string {
    case Admin = 'admin';
    case Engineer = 'engineer';
    case TechLead = 'tech_lead';
}
?>