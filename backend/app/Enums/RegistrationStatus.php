<?php
namespace App\Enums;
enum RegistrationStatus:string { case Pending='pending'; case Confirmed='confirmed'; case Waitlisted='waitlisted'; case Rejected='rejected'; case Cancelled='cancelled'; }
