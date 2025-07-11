<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CitySelect extends Component
{
    public $cities = []; // All cities
    public $inputsearch = ''; // Text user types
    public $searchResults = []; // Filtered results

    public $selectedCity = ''; // Value (e.g. city ID or slug)
    public $selectedLabel = ''; // Label (e.g. "Amsterdam")

    public function mount()
    {
        // Replace this with actual data source (e.g. database or config)
        $this->cities = [
            ['value' => 'ams', 'label' => 'Amsterdam'],
            ['value' => 'rot', 'label' => 'Rotterdam'],
            ['value' => 'utr', 'label' => 'Utrecht'],
            ['value' => 'eind', 'label' => 'Eindhoven'],
            ['value' => 'gron', 'label' => 'Groningen'],
        ];
    }

    public function updatedInputsearch()
    {
        $this->searchResults = collect($this->cities)
            ->filter(function ($city) {
                return str_contains(strtolower($city['label']), strtolower($this->inputsearch));
            })
            ->take(10)
            ->values()
            ->all();
    }

    public function selectCity($value, $label)
    {
        $this->selectedCity = $value;
        $this->selectedLabel = $label;
        $this->inputsearch = $label;
        $this->searchResults = [];
    }

    public function render()
    {
        return view('livewire.city-select');
    }
}
