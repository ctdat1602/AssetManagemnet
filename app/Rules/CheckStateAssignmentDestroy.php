<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Assignment;
use App\Models\RequestForReturning;

class CheckStateAssignmentDestroy implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $assignment = Assignment::find($value);
        if ($assignment) {
            if ($assignment->status_id == Assignment::$assignmentStatusAccepted) {
                return false;
            }
            $list = RequestForReturning::where('assignment_id', $value)
                ->count();
            if ($list == 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Assignment';
    }
}
