    <x-app-layout>
        <x-slot name="header">
            <x-header>
                Dashboard
            </x-header>
        </x-slot>

        <x-container>

            <x-form post :action="route('question.store')">

                <x-textarea label='Question' name='question' />

                <x-btn.primary>Save</x-btn.primary>

                <x-btn.reset>Cancel</x-btn.res>

            </x-form>

        </x-container>

    </x-app-layout>
