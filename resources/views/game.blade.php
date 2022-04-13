<x-app-layout>
    @push('styles')
    <style type="text/css">
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .refresh {
            animation: rotate 1.5s infinite linear;
        }
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Game') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-center">
                        <img id="circle" class="refresh" src="{{ asset('img/circle.png') }}" alt="circle" width="250" height="250" />
                    </div>

                    <p id="winner" class="mt-6 text-xl leading-6 font-medium text-red-900">11</p>

                    <hr class="mt-6 border-gray-200" />

                    <div class="mt-6 text-center">
                        <label class="inline-flex items-center cursor-pointer">
                            Your bet
                        </label>
                        <select
                            id="bet"
                            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option selected>Not in</option>
                            @foreach (range(1, 12) as $number)
                                <option>{{ $number }}</option>
                            @endforeach
                        </select>

                        <hr class="mt-6 border-gray-200" />
                        <p class="mt-6 text-xl leading-6 font-medium text-gray-900">Remaining time</p>
                        <p id="timer" class="mt-6 text-xl leading-6 font-medium text-red-900">Waiting to start</p>
                        <hr class="mt-6 border-gray-200" />
                        <p id="result" class="mt-6 text-xl leading-6 font-medium text-gray-900"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const circleElement = document.getElementById("circle");
        const winnerElement = document.getElementById("winner");
        const betElement = document.getElementById("bet");
        const timerElement = document.getElementById("timer");
        const resultElement = document.getElementById("result");

        window.Echo.channel("game")
            .listen("RemainingTimeChanged", (e) => {
                timerElement.innerText = e.time;

                circleElement.classList.add("refresh");

                winnerElement.classList.add("invisible");

                resultElement.innerText = "";

                winnerElement.classList.remove("text-green-900");
                winnerElement.classList.remove("text-red-900");
            })
            .listen("WinnerNumberGenerated", (e) => {
                circleElement.classList.remove("refresh");

                let winner = e.number;

                winnerElement.innerText = winner;

                winnerElement.classList.remove("invisible");

                let bet = betElement[betElement.selectedIndex].value;

                if (bet === winner) {
                    resultElement.innerText = "You won!";
                    resultElement.classList.add("text-green-900");
                } else {
                    resultElement.innerText = "You lost!";
                    resultElement.classList.add("text-red-900");
                }
            });
    </script>
    @endpush
</x-app-layout>
