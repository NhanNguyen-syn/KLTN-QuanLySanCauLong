<?php

namespace Botble\CourtBooking\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\CourtBooking\Http\Requests\CourtBookingRequest;
use Botble\CourtBooking\Models\CourtBooking;

class CourtBookingForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(CourtBooking::class)
            ->setValidatorClass(CourtBookingRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
