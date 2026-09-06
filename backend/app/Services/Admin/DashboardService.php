<?php
namespace App\Services\Admin;
use App\Models\{User,Tournament,Club,Venue};
class DashboardService { public function summary(): array{return ['users'=>User::count(),'tournaments'=>Tournament::count(),'clubs'=>Club::count(),'venues'=>Venue::count()];} }
