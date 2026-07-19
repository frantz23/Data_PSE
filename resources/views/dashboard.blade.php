<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 leading-tight">
            <p>
                    Role: {{ auth()->user()->getRoleNames()->first() }}

            </p>
        </h2>
    </x-slot>
    <style>
        /* .panel:hover{
           background: linear-gradient(
        135deg,
        #000000 0%,
        #1a0000 40%,
        #8B0000 100%
    );
    min-height: 100vh;
    color: white;
        } */

        .panel{
    background: linear-gradient(
        135deg,
        #000000 0%,
        #1a0000 40%,
        #8B0000 100%
    );
    color:white;
}
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('ownpage.pannel') }}" class="panel"
                    style="border:1px solid red;
                    padding:5px;
                    border-radius:3px;

                    ">
                    Access to the panel</a>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
