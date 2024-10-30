    <x-app-layout>
        <x-slot name="header">
            <x-header>
                Vote for a question
            </x-header>
        </x-slot>

        <x-container>

            <x-form get :action="route('dashboard')" class='flex items-center space-x-2 mb-4'>
                <x-text-input name='search' :value='request()->search' class='w-full' />
                <x-btn.primary>Search</x-b.primary>
            </x-form>

            @unless ($questions->count())
                <div class="dark:text-gray-300 flex text-center flex-col justify-center pt-2">
                    <div class='justify-center flex'>
                        <x-draw.searching width='300' />
                    </div>
                    <div class='mt-4 dark:text-gray-400 font-bold text-2xl'>
                        Question not found
                    </div>
                </div>
            @else
                <div class="dark:text-gray-400 uppercase font-bold mb-2">List of Questions</div>

                <div class="dark:text-gray-400 space-y-3">
                    @foreach ($questions as $question)
                        <x-question :$question />
                    @endforeach

                    {{ $questions->withQueryString()->links() }}
                </div>

            @endunless

        </x-container>

    </x-app-layout>
