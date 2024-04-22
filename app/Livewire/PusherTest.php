<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class PusherTest extends Component
{
    use LivewireAlert;

    public function mount()
    {
        //
    }

    #[On('echo:order-location, OrderLocationChangeEvent')]
    public function realTimeMessage()
    {
       $this->download();
    }

    public function render()
    {
        return view('livewire.pusher-test');
    }

    public function download()
    {
        return dd('asdf');
    }
}
