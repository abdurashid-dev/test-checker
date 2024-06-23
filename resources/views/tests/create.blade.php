<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Test qo'shish
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg dark:text-white mt-3">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="relative overflow-x-auto">
                        <form action="{{ route('tests.store') }}" method="post">
                            @csrf
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="name"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-200">Test
                                        nomi</label>
                                    <input type="text" name="name" id="name"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="description"
                                           class="block text-sm font-medium text-gray-700 dark:text-gray-200">Javoblar</label>
                                    <input type="text" name="answers" id="answers"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-white">
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Javoblar quyidagicha bo'lishi kerak. Masalan: 1a2b3c4d
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Saqlash
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
