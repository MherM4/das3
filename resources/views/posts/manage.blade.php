@include('components.header')

<main style="max-width: 900px; margin: 30px auto;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Իմ Գրառումները</h1>
        <a href="{{ route('posts.create') }}" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">+ Ստեղծել Նորը</a>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white;">
        <thead>
        <tr style="background: #eee; text-align: left;">
            <th style="padding: 10px;">Վերնագիր</th>
            <th style="padding: 10px;">Ամսաթիվ</th>
            <th style="padding: 10px;">Գործողություն</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px;">{{ $post->title }}</td>
                <td style="padding: 10px;">{{ $post->created_at->format('d.m.Y') }}</td>
                <td style="padding: 10px; display: flex; gap: 10px;">
                    <a href="{{ route('posts.edit', $post->id) }}" style="color: orange;">Խմբագրել</a>

                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" style="color: red; border: none; background: none; cursor: pointer;">Ջնջել</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
