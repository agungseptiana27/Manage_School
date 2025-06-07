<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        <x-filament::button type="submit"
            class="mt-4 bg-green-500 w-40 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Simpan
        </x-filament::button>
    </form>
</x-filament-panels::page>