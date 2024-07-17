<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <title>Sticky Notes</title>
</head>
<body>
    <div class="min-h-full">
        @include('components.header')

        <header class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-6 mt-10 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                    All Notes
                </h1>
            </div>
        </header>
        <div class="mt-20 mx-auto max-w-7xl md:flex">
            @foreach ($notes as $note)
                <div class="bg-yellow-400 md:w-1/3 p-4 m-5">
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            @php
                                $user = \App\Models\User::find($note->user_id);
                            @endphp
                            {{ $user->name }}
                        </div>
                        <div class="flex gap-2">
                            <input type="button" id="submit"
                                   class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto cursor-pointer px-2 py-2.5 text-center"
                                   value="Update">
                            <form
                                action="{{ route('deleteNote', ['userId' => $note->user_id, 'noteId' => $note->id]) }}"
                                method="post">
                                @csrf
                                <input type="submit"
                                       class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto cursor-pointer px-2 py-2.5 text-center"
                                       value="Delete">
                            </form>
                        </div>
                    </div>
                    <form id="form" action="{{ route('updateNote', ['userId' => $note->user_id, 'noteId' => $note->id]) }}"
                          method="post">
                        @csrf
                        <input class="text-yellow-950 border-none" name="note" value="{{ $note->note }}">
                    </form>
                    <p class="text-yellow-950 mt-5 border-none">{{ $note->created_at }}</p>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        document.getElementById('submit').addEventListener('click', function () {
            document.getElementById('form').submit();
        });
    </script>
</body>
</html>
