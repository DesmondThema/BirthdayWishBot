<?php

namespace App\Console\Commands;

use App\Mail\HappyBirthday;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBirthdayWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'realm-digital:send-birthday-wishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday wishes to Realm Digital Employees';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     */
    public function handle()
    {
        $employees = $this->getEmployeesData();

        $employees->each(function ($employee) { 
            if (
                $this->isEmployeeBirthday($employee['dateOfBirth']) &&
                $this->isEmployeeWorkingForOrganisation($employee) &&
                !$this-$this->isEmployeeExcluded($employee['id'])
            ) {
                dump("Sending birthday wish to ");
                Mail::to('des@gmail.com')->send(new HappyBirthday($employee));
            }
        });
    }


    /**
     * Get data of employees
     *
     * @return Collection
     */
    public function getEmployeesData(): Collection
    {
        $response = Http::get('https://interview-assessment-1.realmdigital.co.za/employees');
        return $response->collect();
    }

    /**
     * Get id's of employees who don't
     * Want to receive birthday emails
     *
     * @return Collection
     */
    public function getExclusionIds(): Collection
    {
        $response = Http::get('https://interview-assessment-1.realmdigital.co.za/do-not-send-birthday-wishes');
        return $response->collect();
    }

    /**
     * Check if it is employee's birthday
     *
     * @param $dateOfBirth
     * @return bool
     */
    public function isEmployeeBirthday($dateOfBirth): bool
    {
        if (Carbon::parse($dateOfBirth)->isBirthday()) {
            return true;
        }

        return false;
    }

    /**
     * Check if employee is excluded
     * from receiving birthday emails
     *
     * @param $id
     * @return bool
     */
    public function isEmployeeExcluded($id): bool
    {
        $ids = $this->getExclusionIds()->toArray();

        if (in_array($id, $ids)) {
            return true;
        }
        return false;
    }

    /**
     * Check if employee has started working
     * or still working for the organisation
     *
     * @param $employee
     * @return bool
     */
    public function isEmployeeWorkingForOrganisation($employee): bool
    {
        $isEmployeeWorking = false;
        $todayDate = Carbon::now();

        if (isset($employee['employmentStartDate'])) {
            $employeeStartDate = Carbon::parse($employee['employmentStartDate']);
            if ($employeeStartDate->isBefore($todayDate))
                $isEmployeeWorking = true;
        }

        if (isset($employee['employmentEndDate'])) {
            $employmentEndDate = Carbon::parse($employee['employmentEndDate']);
            if ($employmentEndDate->isAfter($todayDate))
                $isEmployeeWorking = true;
        }

        return $isEmployeeWorking;
    }
}
