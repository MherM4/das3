@include('components.header')

<main style="max-width: 800px; margin: 30px auto; font-family: sans-serif; padding: 0 15px;">

    <h1 style="color: #333; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
        🔖 Պահպանված գրառումներ
    </h1>

    @forelse($posts as $post)
        @include('components.post-card', ['post' => $post])
    @empty
        <div style="text-align: center; padding: 50px; background: white; border-radius: 12px; border: 1px dashed #ccc;">
            <p style="color: #777; font-size: 18px;">Դուք դեռ ոչ մի գրառում չեք պահպանել։</p>
            <a href="{{ route('home') }}" style="color: #007bff; font-weight: 600; text-decoration: none;">Վերադառնալ գլխավոր էջ</a>
        </div>
    @endforelse

</main>

<style>
    body { background-color: #f8f9fa; }
</style>
