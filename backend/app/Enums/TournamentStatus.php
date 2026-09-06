<?php
namespace App\Enums;
enum TournamentStatus:string { case Draft='draft'; case Published='published'; case Ongoing='ongoing'; case Completed='completed'; case Cancelled='cancelled'; }
