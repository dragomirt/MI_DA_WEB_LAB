<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h1 class="text-xl">API Keys</h1>

                    <form action="{{ route('generate_token') }}" method="POST">
                        @csrf
                        <button class="px-5 py-3 mt-2 mb-4 rounded-xl text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-800 active:bg-grey-900 focus:outline-none border-4 border-white focus:border-purple-200 transition-all" type="submit">
                            <i class="fas fa-key mr-2"></i>Generate New Token</button>
                    </form>


                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="text-left">Token</th>
                            <th class="text-left">Last Used</th>
                            <th class="text-left">Created</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($tokens as $token)
                                <tr>
                                    <td>{{ $token->token }}</td>
                                    <td>{{ \Carbon\Carbon::parse($token->last_used_at)->diffForHumans() }}</td>
                                    <td>{{ \Carbon\Carbon::parse($token->created_at)->diffForHumans() }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-xl">Files</h1>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
