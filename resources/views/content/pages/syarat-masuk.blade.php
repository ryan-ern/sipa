@extends('layouts/contentNavbarLayout')

@section('title', 'Syarat Masuk')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('syarat-masuk.update', $data->id) }}" enctype="multipart/form-data" id="form"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div id="form-article">
                            <label for="isi" class="form-label fs-5 mb-5">Data Persyaratan</label>
                            <div id="toolbar-container">
                                <span class="ql-formats">
                                    <select class="ql-font"></select>
                                    <select class="ql-size"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-color"></select>
                                    <select class="ql-background"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-script" value="sub"></button>
                                    <button class="ql-script" value="super"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-header" value="1"></button>
                                    <button class="ql-header" value="2"></button>
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-code-block"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-indent" value="-1"></button>
                                    <button class="ql-indent" value="+1"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-direction" value="rtl"></button>
                                    <select class="ql-align"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                    <button class="ql-formula"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                            </div>
                            <div id="quill-editor" style="height: 300px;">{!! $data->isi !!}</div>
                            <input type="hidden" id="isi" name="isi" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Tulis isi syarat masuk di sini...',
                modules: {
                    toolbar: '#toolbar-container'
                }
            });

            const form = document.getElementById('form');
            form.addEventListener('submit', function() {
                const hiddenInput = form.querySelector('input[name="isi"]');
                if (quill) {
                    hiddenInput.value = quill.root.innerHTML;
                }
            });
        });
    </script>
@endsection
