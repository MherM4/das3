<x-app-layout>
    <x-slot:title>{{ __('messages.my_posts') }}</x-slot:title>

<main style="max-width: 900px; margin: 30px auto;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>{{ __('messages.my_posts') }}</h1>
        <a href="{{ route('posts.create') }}" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">{{ __('messages.create_new') }}</a>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white;">
        <thead>
        <tr style="background: #eee; text-align: left;">
            <th style="padding: 10px;">{{ __('messages.title') }}</th>
            <th style="padding: 10px;">{{ __('messages.date') }}</th>
            <th style="padding: 10px;">{{ __('messages.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px;">{{ $post->title }}</td>
                <td style="padding: 10px;">{{ $post->created_at->format('d.m.Y') }}</td>
                <td style="padding: 10px; display: flex; gap: 10px;">
                    <a href="{{ route('posts.edit', $post->id) }}" style="color: orange;">{{ __('messages.edit') }}</a>

                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" style="color: red; border: none; background: none; cursor: pointer;">{{ __('messages.delete') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
</x-app-layout>
