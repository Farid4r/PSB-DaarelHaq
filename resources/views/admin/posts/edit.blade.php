@extends('layouts.app')

@section('title', 'Edit Berita - Admin')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('admin.posts.index') }}" class="text-gray-500 hover:text-gray-700">
                    &larr; Kembali
                </a>
                <h2 class="text-2xl font-bold text-emerald-900">Edit Berita</h2>
            </div>

            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Berita</label>
                    <input type="text" name="title" id="title" value="{{ $post->title }}" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Thumbnail Saat Ini</label>
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-32 h-20 object-cover rounded mb-2 border">
                        @endif
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status Publikasi</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                            <option value="publish" {{ $post->status == 'publish' ? 'selected' : '' }}>Terbitkan (Publish)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Isi Berita</label>
                    <textarea name="content" id="editor" class="w-full">{{ $post->content }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2 px-8 rounded-lg transition duration-200">
                        Perbarui Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
        })
        .catch(error => {
            console.error(error);
        });
</script>

<style>
    .ck-editor__editable {
        min-height: 400px;
    }
</style>
@endsection