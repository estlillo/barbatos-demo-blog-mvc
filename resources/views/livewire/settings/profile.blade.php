<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    public ?string $phone = null;
    public ?string $birth_date = null;
    public ?string $address = null;
    public ?string $gender = null;
    public ?string $nationality = null;
    public ?string $biography = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;

        $person = $user->person;
        if ($person) {
            $this->phone = $person->phone;
            $this->birth_date = $person->birth_date;
            $this->address = $person->address;
            $this->gender = $person->gender;
            $this->nationality = $person->nationality;
            $this->biography = $person->biography;
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
            'phone' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:male,female,other'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'biography' => ['nullable', 'string'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $person = $user->person;
        if ($person) {
            $person->update([
                'phone' => $this->phone,
                'birth_date' => $this->birth_date,
                'address' => $this->address,
                'gender' => $this->gender,
                'nationality' => $this->nationality,
                'biography' => $this->biography,
            ]);
        }

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Perfil')" :subheading="__('Actualiza tu nombre y correo electrónico')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Nombre')" type="text" required autofocus autocomplete="name" />
            <flux:input wire:model="phone" :label="__('Teléfono')" type="text" />
            <flux:input wire:model="birth_date" :label="__('Fecha de nacimiento')" type="date" />
            <flux:input wire:model="address" :label="__('Dirección')" type="text" />
            <flux:select wire:model="gender" :label="__('Género')">
                <option value="">{{ __('Selecciona género') }}</option>
                <option value="male">{{ __('Masculino') }}</option>
                <option value="female">{{ __('Femenino') }}</option>
                <option value="other">{{ __('Otro') }}</option>
            </flux:select>
            <flux:input wire:model="nationality" :label="__('Nacionalidad')" type="text" />
            <flux:textarea wire:model="biography" :label="__('Biografía')" />

            <div>
                <flux:input wire:model="email" :label="__('Correo electrónico')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Tu correo electrónico no está verificado.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Guardar') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Guardado.') }}
                </x-action-message>
            </div>
        </form>
        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
