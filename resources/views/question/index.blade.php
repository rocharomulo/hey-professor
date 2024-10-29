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

            <div class="dark:text-gray-400 uppercase font-bold mb-2">Drafts</div>

            <div class="dark:text-gray-400 space-y-4">

                <x-table>
                    <x-table.head>
                        <tr>
                            <x-table.th>Question</x-table.th>
                            <x-table.th>Actions</x-table.th>
                        </tr>
                    </x-table.head>
                    <tbody>
                        @foreach ($questions->where('draft', true) as $question)
                            <x-table.tr>
                                <x-table.td>{{ $question->question }}</x-table.td>
                                <x-table.td>
                                    <x-form delete :action="route('question.destroy', $question)">
                                        <button class='hover:underline text-blue-500'>Delete</button>
                                    </x-form>
                                    <x-form put :action="route('question.publish', $question)">
                                        <button class='hover:underline text-blue-500'>Publish</button>
                                    </x-form>
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </tbody>
                </x-table>
            </div>

            <div class="dark:text-gray-400 uppercase font-bold mb-2 mt-5">Published Questions</div>

            <div class="dark:text-gray-400 space-y-4">

                <x-table>
                    <x-table.head>
                        <tr>
                            <x-table.th>Question</x-table.th>
                            <x-table.th>Actions</x-table.th>
                        </tr>
                    </x-table.head>
                    <tbody>
                        @foreach ($questions->where('draft', false) as $question)
                            <x-table.tr>
                                <x-table.td>{{ $question->question }}</x-table.td>
                                <x-table.td>
                                    <x-form delete :action="route('question.destroy', $question)">
                                        <button class='hover:underline text-blue-500'>Delete</button>
                                    </x-form>
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </tbody>
                </x-table>
            </div>

        </x-container>

    </x-app-layout>
