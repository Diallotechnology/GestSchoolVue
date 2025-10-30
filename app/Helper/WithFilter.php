<?php

declare(strict_types=1);

namespace App\Helper;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

trait WithFilter
{
    use WithPagination;

    #[Validate('string')]
    public string $search = '';

    public string $etat = '';

    public string $date = '';

    #[Locked]
    private bool $form_type = false;

    public array $selectedRows = [];

    public function selectAll(): void
    {
        $this->selectedRows = $this->rows->pluck('id')->toArray();
    }

    public function deselectAll(): void
    {
        $this->selectedRows = [];
    }


    public function toggleSelectAll(): void
    {
        if (count($this->selectedRows) === $this->rows->count()) {
            $this->deselectAll();
        } else {
            $this->selectAll();
        }
    }

    public function bulkAction(string $action = ""): void
    {
        dd($this->selectedRows);

        $this->reset('selectedRows');
        flash(' applied items successfully.');
    }
}
