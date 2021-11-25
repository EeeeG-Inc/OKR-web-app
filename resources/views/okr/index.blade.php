<x-guest-layout>
    <!-- TODO:header と footer の表示 -->
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
            OKR一覧
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
            <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>YEAR</th>
                <th>OKR</th>
            </tr>
        </thead>
        <tbody>
        <tbody>
            @foreach($okrs as $okr)
                <tr>
                    <td>{{ $okr->year }}</td>
                    <td>{{ $okr->name }}</td>
                </tr>
            @endforeach
        </tbody>
        {{ $okrs->links() }}
    </table>
            </div>
        </div>
    </div>
</x-guest-layout>