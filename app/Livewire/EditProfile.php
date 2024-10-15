<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasSort;
use Joaopaulolndev\FilamentEditProfile\Livewire\EditProfileForm;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

class EditProfile extends EditProfileForm
{
    public function mount(): void
    {
        $this->user = $this->getUser();

        $this->userClass = get_class($this->user);

        $this->form->fill($this->user->only('avatar_url', 'name', 'email'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Informações do Perfil'))
                    ->aside()
                    ->description(__('Atualize suas informações do perfil'))
                    ->schema([
                        // FileUpload::make('avatar_url')
                        //     ->label(__('filament-edit-profile::default.avatar'))
                        //     ->avatar()
                        //     ->imageEditor()
                        //     ->directory(filament('filament-edit-profile')->getAvatarDirectory())
                        //     ->rules(filament('filament-edit-profile')->getAvatarRules())
                        //     ->hidden(! filament('filament-edit-profile')->getShouldShowAvatarForm()),
                        TextInput::make('name')
                            ->label(__('Nome'))
                            ->required(),
                        // TextInput::make('email')
                        //     ->label(__(''))
                        //     ->email()
                        //     ->required()
                        //     ->unique($this->userClass, ignorable: $this->user),
                    ]),
            ])
            ->statePath('data');
    }

    public function updateProfile(): void
    {
        try {
            $data = $this->form->getState();

            $this->user->update($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-edit-profile::default.saved_successfully'))
            ->send();
    }
}
