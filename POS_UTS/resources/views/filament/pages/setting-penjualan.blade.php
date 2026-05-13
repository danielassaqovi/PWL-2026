<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-wrap items-center gap-4 justify-start">
            {{ $this->getSaveFormAction() }}
        </div>
    </form>
</x-filament-panels::page>
