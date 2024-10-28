    <x-app-layout>
        <x-slot name="header">
            <x-header>
                My Questions
            </x-header>
        </x-slot>

        <x-container>

            <x-form post :action="route('question.store')">

                <x-textarea label='Question' name='question' />

                <x-btn.primary>Save</x-btn.primary>

                <x-btn.reset>Cancel</x-btn.res>

            </x-form>

            <hr class='border-gray-700 border-dashed my-4'>

            <div class="dark:text-gray-400 uppercase font-bold mb-2">List of Questions</div>

            <div class="dark:text-gray-400 space-y-3">
                @foreach ($questions as $question)
                    <x-question :$question />
                @endforeach
            </div>

        </x-container>

    </x-app-layout>
