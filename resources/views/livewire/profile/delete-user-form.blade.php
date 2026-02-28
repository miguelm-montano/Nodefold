<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/');
    }
}; ?>

<section class="space-y-6">
  <header>
    <h2 class="text-medium font-medium text-gray-900">
      {{ __('Delete Account') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600">
      {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
    </p>
  </header>

  <x-text-input wire:model="password" type="password" class="block w-full" placeholder="{{ __('Password') }}" />
  <x-input-error :messages="$errors->get('password')" class="mt-2" />

  <button wire:click.prevent="deleteUser" wire:confirm="Are you sure you want to delete your account?"
    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition text-sm">
    {{ __('Delete Account') }}
  </button>

</section>
