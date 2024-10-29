    <x-app-layout>
        <x-slot name="header">
            <x-header>
                Vote for a question
            </x-header>
        </x-slot>

        <x-container>

            <hr class='border-gray-700 border-dashed my-4'>

            <div class="dark:text-gray-400 uppercase font-bold mb-2">List of Questions</div>

            <div class="dark:text-gray-400 space-y-3">
                @foreach ($questions as $question)
                    <x-question :$question />
                @endforeach

                {{ $questions->links() }}
            </div>

        </x-container>

    </x-app-layout>
