<?php

namespace App\Services;

use App\Notifications\EmployeesMessage;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

class SendMessages
{
    private $realmAPI;

    public function __construct(RealmAPI $realmAPI)
    {
        $this->realmAPI = $realmAPI;
    }

    public function sendBirthdayWishes(): string
    {
        //getting all resources from realm api
        $employees = collect($this->realmAPI->getEmployees('/employees'));
        $dontSendBirthdayWishes = collect($this->realmAPI->getDontSendBirthdayWishes('/do-not-send-birthday-wishes'));

        // removing employees that should not receive birthday wishes
        $filteredEmployees = $employees->whereNotIn('id', $dontSendBirthdayWishes->all());
        $employeesToSendWishesTo = collect([]);

        //looping through all employees that should receive birthday wishes
        $filteredEmployees->each(function ($employee) use ($employeesToSendWishesTo) {
            //checking if is a valid employee
            if (Arr::exists($employee, 'name') && Arr::exists($employee, 'dateOfBirth')) {
                //converting all string dates to Carbon instances to do the comparisons
                $today = now();
                $dateOfBirth = Carbon::parse($employee['dateOfBirth']);
                $employmentStartDate = Carbon::parse($employee['employmentStartDate']);

                //picking only employees who should receive birthday wishes
                if ($employee['employmentEndDate'] == null
                    && !$employmentStartDate->gt(now())
                    && $dateOfBirth->format('m') == $today->format('m')
                    && $dateOfBirth->format('d') == $today->format('d')) {

                    $employeesToSendWishesTo->push($employee['name']);
                }
            }
        });

        //comma separated employees names
        $employeesNames = implode(', ', $employeesToSendWishesTo->toArray());
        //message to send
        $message = "Happy Birthday { $employeesNames }";
        /*sending out the email to relavant email address and passing the message to EmployeesMessage which will allow
        * us to re-use it on workAnniversary function.
        */
        Notification::route('mail', 'test@realm.com')->notify(new EmployeesMessage($message));

        //return the employees names in case we would like to use it for something else after sending their wishes.
        return "success";
    }

//    we can create a workAnniversary if we want then we can use it any where if we inejct this class or create a new one.
//    public function sendWorkAnniversary(){
//
//    }
}
