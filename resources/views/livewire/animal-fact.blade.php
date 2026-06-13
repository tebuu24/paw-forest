<?php
use function Livewire\Volt\{state, mount};
use Illuminate\Support\Facades\Http;
state([
    'animalName' => '',
    'animalSlogan' => '',
    'animalDiet' => '',
    'animalLifespan' => ''
]);

mount(function () {
    $this->fetchAnimalFact();
});
$fetchAnimalFact = function () {
    $pool = ['fox', 'wolf', 'otter', 'panda', 'cheetah', 'koala', 'lemur', 'dolphin'];
    $randomAnimal = $pool[array_rand($pool)];
    try {
        $response = Http::withHeaders([
            'X-Api-Key' => env('API_NINJAS_KEY')
        ])->timeout(4)->get('https://api.api-ninjas.com/v1/animals', [
            'name' => $randomAnimal
        ]);
        if ($response->successful() && !empty($response->json())) {
            $data = $response->json()[0];

            $this->animalName = $data['name'] ?? 'Animal';
            $this->animalSlogan = $data['characteristics']['slogan'] ?? __('No slogan available.');
            $this->animalDiet = $data['characteristics']['diet'] ?? __('Unknown');
            $this->animalLifespan = $data['characteristics']['lifespan'] ?? __('Unknown');
        } else {
            $this->animalSlogan = __('Could not retrieve animal data right now.');
        }
    } catch (\Exception $e) {
        $this->animalSlogan = __('Network connection error. Try again later!');
    }
};
?>
<div class="fact-section block-card" style="text-align: center; padding: 2rem; margin: 2rem 0;">
    <h2>🐾 {{ __('Did You Know?') }}</h2>
    
    <div class="fact-container" style="min-height: 100px; margin: 1.5rem 0;">
        <p wire:loading wire:target="fetchAnimalFact">
            {{ __('Looking up an extraordinary creature...') }}
        </p>
        <div wire:loading.remove wire:target="fetchAnimalFact">
            <h3 style="color: var(--primary-color); margin-bottom: 0.5rem; text-transform: capitalize;">
                {{ $animalName }}
            </h3>
            <p style="font-size: 1.1rem; line-height: 1.6; font-style: italic; margin-bottom: 1rem;">
                "{!! $animalSlogan !!}"
            </p>
            <p style="font-size: 0.9rem; opacity: 0.8;">
                <strong>{{ __('Diet') }}:</strong> {{ $animalDiet }} | 
                <strong>{{ __('Lifespan') }}:</strong> {{ $animalLifespan }}
            </p>
        </div>
    </div>
    <button wire:click="fetchAnimalFact" class="btn btn-blue" wire:loading.attr="disabled">
        <span>{{ __('Get Another Fact') }}</span>
    </button>
</div>