<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Laravel\Sanctum\PersonalAccessToken;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Relation::make('tokens.')
                ->fromModel(PersonalAccessToken::class, 'token')
                ->title('Your tokens')
                ->readonly()
        ];
    }
}
