    <x-app-layout>
        <x-slot name="header">
            <x-header>
                Edit Question {{ $question->id }}
            </x-header>
        </x-slot>

        <x-container>

            <x-form put :action="route('question.update', $question)">

                <x-textarea label='Question' name='question' :value='$question->question' />

                <x-btn.primary>Save</x-btn.primary>

                <x-btn.reset>Cancel</x-btn.res>

            </x-form>

        </x-container>

    </x-app-layout>
